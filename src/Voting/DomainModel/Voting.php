<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\DomainModel;

use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

class Voting
{
    private array $events = [];
    private string $name;
    private WinningStrategy $winningStrategy;
    private int $quorum;
    private UuidInterface $uuid;
    private array $voters;
    private int $for = 0;
    private int $against = 0;
    private bool $result;
    private Carbon $startedAt;
    private int $limit;

    public function __construct()
    {
    }

    public static function loadFromStorage(array $data)
    {
        $self = new self();
        $self->uuid = $data['uuid'];
        $self->name = $data->getName();
        $self->winningStrategy = $data->getWinningStrategy();
        $self->quorum = $data->getQuorum();
        $self->startedAt = $data['startedAt'];
        $self->limit = $data->getTimeLimit();

        return $self;
    }

    public static function createNew(CreateVotingCommand $command)
    {
        $self = new self();
        $self->uuid = $command->getUuid();
        $self->name = $command->getName();
        $self->winningStrategy = $command->getWinningStrategy();
        $self->quorum = $command->getQuorum();
        $self->startedAt = new Carbon('now');
        $self->limit = $command->getTimeLimit();
        $self->events[] = new VotingWasCreated();

        return $self;
    }

    public function castVote(CastVoteCommand $command): void
    {
        $voterId = $command->getVoterId()->toString();
        if (!in_array($voterId, $this->voters)) {
            $this->voters[] = $voterId;
            $command->isVote() ? $this->for++ : $this->against++;
        }
    }

    public function finishOnTimeLimit(): void
    {
        if ($this->startedAt->addMinutes($this->limit) > Carbon::now()) {
            $this->finishVoting();
        }
    }

    public function finishOnAllVoteCast(): void
    {
        if (count($this->voters) === $this->quorum) {
            $this->finishVoting();
        }
    }

    private function finishVoting(): void
    {
        $this->result = $this->winningStrategy->whoWon($this->for, $this->against);
        $this->events[] = new VotingWasClosed($this->result, $this->uuid);
    }

    private function extract(): array
    {
        return [
            'uuid' => $this->uuid,
            'limit' => $this->limit
        ];
    }

    private function popRecordedEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}
