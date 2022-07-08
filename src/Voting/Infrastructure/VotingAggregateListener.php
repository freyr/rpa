<?php

namespace Freyr\RPA\Voting\Infrastructure;

use Freyr\RPA\Voting\DomainModel\VotingWasClosed;
use Freyr\RPA\Voting\DomainModel\VotingWasCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VotingAggregateListener implements EventSubscriberInterface
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


    }

    public function onVotingWasClosed(VotingWasClosed $event)
    {

    }
}
