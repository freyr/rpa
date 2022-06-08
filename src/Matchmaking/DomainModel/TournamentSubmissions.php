<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\DomainModel;

use Exception;
use Freyr\RPA\Matchmaking\DomainModel\Events\ParticipantWasAddedToTheWaitingList;
use Freyr\RPA\Matchmaking\DomainModel\Events\ParticipantWasRemovedFromTheWaitingList;
use Freyr\RPA\Matchmaking\DomainModel\Events\SubmissionFailedToComplete;
use Freyr\RPA\Matchmaking\DomainModel\Events\SubmissionWasCompleted;
use JsonSerializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TournamentSubmissions implements JsonSerializable
{
    private array $events = [];

    /** @var Submission[] */
    private array $submissions;
    /** @var Participant[] */
    private array $waitingList;
    private UuidInterface $uuid;
    private string $name;

    public function __construct(
        UuidInterface $tournamentSubmissions,
        string $name,
        array $submissions,
        array $waitingList
    ) {
        $this->submissions = $submissions;
        $this->waitingList = $waitingList;
        $this->uuid = $tournamentSubmissions;
        $this->name = $name;
    }

    public static function fromArray(array $data): self
    {
        $submissions = [];
        $waitingParticipants = [];
        foreach ($data['submissions'] as $rawSubmission) {
            $submissions[] = Submission::fromArray($rawSubmission);
        }

        foreach ($data['waiting_participants'] as $participant) {
            $waitingParticipants[$participant['membership_id']] = Participant::fromArray($participant);
        }

        return new self(
            Uuid::fromString($data['uuid']),
            $data['name'],
            $submissions,
            $waitingParticipants
        );
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @throws Exception
     */
    public function processSubmission(Submission $submission): void
    {
        // Cannot process submission with participants that are in any other submission
        if (!$this->assertSubmissionParticipantsUniqueness($submission)) {
            throw new Exception('At least one participant was submitted already');
        }

        // if submission was complete (2 membership cards) or attempt to fill-up empty seats were successful
        if ($submission->isCompleted() || $this->attemptToFillUpSubmissionFromWaitingList($submission)) {
            // remove participant from waiting list
            // we remove them here when we are certain that we can complete submission
            foreach ($submission->getParticipants() as $participant) {
                $this->events[] = $this->removeFromWaitingList($participant);
            }

            // add submission to the list of completed (accepted) submissions
            $this->submissions[] = $submission;

            // emit event that could be used as a trigger to handle any side effect later
            $this->events[] = new SubmissionWasCompleted($this->name, $this->getUuid(), $submission);
        } else {
            // If there is not enough participants on the waiting list to fill-up this submission.
            // Move participants from this submission to the waiting list
            foreach ($submission->getParticipants() as $participant) {
                $this->events[] = $this->addParticipantToTheWaitingList($participant);
            }
            $this->events[] = new SubmissionFailedToComplete($submission);
        }
    }

    public function addParticipantToTheWaitingList(Participant $participant): ?ParticipantWasAddedToTheWaitingList
    {
        if (!array_key_exists($participant->getMembershipId(), $this->waitingList)) {
            $this->waitingList[$participant->getMembershipId()] = $participant;
            return new ParticipantWasAddedToTheWaitingList($participant);
        }

        return null;
    }

    public function removeFromWaitingList(Participant $participant): ?ParticipantWasRemovedFromTheWaitingList
    {
        if (array_key_exists($participant->getMembershipId(), $this->waitingList)) {
            $participant = $this->waitingList[$participant->getMembershipId()];
            $this->waitingList[$participant->getMembershipId()] = null;
            $this->waitingList = array_filter($this->waitingList);
            return new ParticipantWasRemovedFromTheWaitingList($participant);
        }

        return null;
    }

    private function assertSubmissionParticipantsUniqueness(Submission $submission): bool
    {
        /** @var Submission $acceptedSubmission */
        foreach ($this->submissions as $acceptedSubmission) {
            if ($acceptedSubmission->hasParticipantFrom($submission)) {
                return false;
            }
        }

        return true;
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid->toString(),
            'name' => $this->name,
            'submissions' => $this->submissions,
            'waiting_participants' => $this->waitingList
        ];
    }

    /**
     * @throws Exception
     */
    protected function attemptToFillUpSubmissionFromWaitingList(Submission $submission): bool
    {
        foreach ($this->waitingList as $potentialParticipant) {
            // if potential participant from waiting list is in the submission
            // we should skip it
            // removing them at this point is not advised as it could lead to potential double events if
            // required number of players cannot be filled-up - they all should be transfer to the waiting list again
            // instead we will remove them later as we confirm that all requirements are met
            if ($submission->hasParticipant($potentialParticipant)) {
                continue;
            }

            $submission->addParticipant($potentialParticipant);
            // if this is enough to fill-up submission, end the process...
            if ($submission->isCompleted()) {
                break;
            }
        }

        // there could be a situation where submission will not be completed after processing whole waiting list
        return $submission->isCompleted();
    }

    // this method is used do bind temporary closure and retrieve all events that
    // were generated during lifecycle of this aggregate root
    private function collectEvents(): array
    {
        $events = array_filter($this->events);
        $this->events = [];
        return $events;
    }
}
