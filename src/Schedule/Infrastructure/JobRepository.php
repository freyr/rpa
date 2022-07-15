<?php

namespace Freyr\RPA\Schedule\Infrastructure;

use Freyr\RPA\Schedule\DomainModel\Job;
use Freyr\RPA\Shared\AggregateChanged;
use Redis;

class JobRepository
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis-rpa');
    }

    public function load(string $id): Job
    {
        $len = $this->redis->lLen($id);
        $data = $this->redis->lRange($id, 0, $len);
        $events = [];
        foreach ($data as $row) {
            $payload = json_decode($row, true);
            $class = $payload['_name'];
            $events[] = $class::fromArray($payload);

        }
        return Job::fromStream($events);
    }

    public function store(Job $job)
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};
        $events = $eventExtractor->call($job);
        /** @var AggregateChanged $event */
        foreach ($events as $event) {
            $payload = json_encode($event->payload());
            $id = $event->field('_uuid');
            $this->redis->rPush($id, $payload);
        }
    }
}
