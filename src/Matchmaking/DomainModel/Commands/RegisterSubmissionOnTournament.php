<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\DomainModel\Commands;

use Exception;
use Freyr\RPA\Matchmaking\DomainModel\Participant;
use Ramsey\Uuid\UuidInterface;

class RegisterSubmissionOnTournament
{
    private UuidInterface $submissionId;
    private UuidInterface $tournamentId;
    /** @var Participant[] */
    private array $participants;

    public function __construct(UuidInterface $submissionId, UuidInterface $tournamentId, array $participants)
    {
        $this->submissionId = $submissionId;
        if (count($participants) < 1 || count($participants) > 2) {
            throw new Exception('Submission must have at least one Participant, but not more than two');
        }
        $this->participants = $participants;
        $this->tournamentId = $tournamentId;
    }

    /**
     * @return UuidInterface
     */
    public function getSubmissionId(): UuidInterface
    {
        return $this->submissionId;
    }

    /**
     * @return Participant[]
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function getTournamentId(): UuidInterface
    {
        return $this->tournamentId;
    }
}
