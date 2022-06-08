<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\DomainModel;

use Exception;
use JsonSerializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Submission implements JsonSerializable
{
    /** @var Participant[] */
    private array $participants = [];

    /**
     * @throws Exception
     */
    public function __construct(private UuidInterface $uuid, array $participants)
    {
        foreach ($participants as $participant) {
            $this->addParticipant($participant);
        }
    }

    public static function fromArray(mixed $rawSubmission): self
    {
        $participants = [];
        foreach ($rawSubmission['participants'] as $participant) {
            $participants[] = Participant::fromArray($participant);
        }

        return new self(Uuid::fromString($rawSubmission['uuid']), $participants);
    }

    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function isCompleted(): bool
    {
        return count($this->participants) === 2;
    }

    /**
     * @throws Exception
     */
    public function addParticipant(Participant $potentialParticipant)
    {
        if (count($this->participants) === 2) {
            throw new Exception('Cannot add more than two participants to submission');
        }

        if ($this->hasParticipant($potentialParticipant)) {
            throw new Exception('Another Participant with the same Membership Card ID exists in that submission');
        }

        $this->participants[$potentialParticipant->getMembershipId()] = $potentialParticipant;
    }

    public function hasParticipant(Participant $theirParticipant): bool
    {
        return array_key_exists($theirParticipant->getMembershipId(), $this->participants);
    }

    public function hasParticipantFrom(Submission $submission): bool
    {
        foreach ($submission->getParticipants() as $theirParticipant) {
            if ($this->hasParticipant($theirParticipant)) {
                return true;
            }
        }


        return false;
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid->toString(),
            'participants' => $this->participants,
        ];
    }
}
