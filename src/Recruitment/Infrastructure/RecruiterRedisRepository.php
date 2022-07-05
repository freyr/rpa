<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\Infrastructure;

use Freyr\RPA\Recruitment\DomainModel\Recruiter;
use Freyr\RPA\Recruitment\DomainModel\RecruiterRepository;
use Freyr\RPA\Shared\AggregateChanged;
use Redis;

class RecruiterRedisRepository implements RecruiterRepository
{
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
        $this->redis->connect('127.0.0.1');
    }


    public function getById(string $recruitmentId): Recruiter
    {
        // TODO: Implement getById() method.
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function persist(Recruiter $aggregate)
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};
        $events = $eventExtractor->call($aggregate);
        /** @var AggregateChanged $event */
        foreach ($events as $event) {
            $name = $event::class;

        }
    }
}
