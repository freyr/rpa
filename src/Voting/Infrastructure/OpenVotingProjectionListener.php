<?php

namespace Freyr\RPA\Voting\Infrastructure;

use Freyr\RPA\Voting\DomainModel\VotingWasClosed;
use Freyr\RPA\Voting\DomainModel\VotingWasCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OpenVotingProjectionListener implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            VotingWasCreated::class => ['onVotingWasCreated'],
            VotingWasClosed::class => ['onVotingWasClosed'],
        ];
    }

    public function onVotingWasCreated(VotingWasCreated $event)
    {
        // select po dane
        $sql = 'INSERT INTO open_voting_view () VALUES ()';

    }

    public function onVotingWasClosed(VotingWasClosed $event)
    {
        // select po dane
        $sql = 'UPDATE open_voting_view SET result = :result WHERE uuid = :uuid';

    }
}
