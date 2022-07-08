<?php

namespace Freyr\RPA\Voting\Infrastructure;

use Freyr\RPA\Voting\DomainModel\Voting;
use Freyr\RPA\Voting\DomainModel\VotingRepository;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class VotingRedisRepository implements VotingRepository
{

    public function __construct(private EventDispatcher $dispatcher)
    {
    }

    public function store(Voting $aggregate): void
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};

        $events = $eventExtractor->call($aggregate);
        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }

    }

    public function getByUUid(UuidInterface $getAggregateUuid): Voting
    {
        $data = [];
        return Voting::loadFromStorage($data);
    }


}
