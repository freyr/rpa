<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\DomainModel\Events;

use Freyr\RPA\Matchmaking\DomainModel\Participant;

class ParticipantWasRemovedFromTheWaitingList
{

    /**
     * @param Participant $participant
     */
    public function __construct(Participant $participant)
    {
    }
}
