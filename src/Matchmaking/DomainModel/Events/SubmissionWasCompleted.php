<?php

namespace Freyr\RPA\Matchmaking\DomainModel\Events;

use Freyr\RPA\Matchmaking\DomainModel\Submission;
use Freyr\RPA\Shared\Event;
use Ramsey\Uuid\UuidInterface;

class SubmissionWasCompleted extends Event
{
    protected static string $name = 'submission.was.completed';

    /**
     * @param Submission $submission
     */
    public function __construct(private string $tournamentName, private UuidInterface $id, private Submission $submission)
    {
    }

    /**
     * @return int[]
     */
    public function getMembershipCardsIds(): array
    {
        $cardsId = [];
        foreach ($this->submission->getParticipants() as $participant) {
            $cardsId[] = $participant->getMembershipId();
        }
        return $cardsId;
    }

    /**
     * @return string
     */
    public function getTournamentName(): string
    {
        return $this->tournamentName;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }
}
