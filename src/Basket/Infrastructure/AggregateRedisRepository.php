<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\Infrastructure;

use Freyr\RPA\Basket\DomainModel\Aggregate;
use Freyr\RPA\Shared\AggregateChanged;
use Redis;

class AggregateRedisRepository
{

    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis-rpa');
    }

    public function load(string $id): Aggregate
    {
        $len = $this->redis->lLen($id);
        $data = $this->redis->lRange($id, 0, $len);
        $events = [];
        foreach ($data as $row) {
            $payload = json_decode($row, true);
            $class = $payload['_name'];
            $events[] = $class::fromArray($payload);

        }
        return Aggregate::fromStream($events);
    }

    public function store(Aggregate $aggregate)
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};
        $events = $eventExtractor->call($aggregate);
        /** @var AggregateChanged $event */
        foreach ($events as $event) {
            $payload = json_encode($event->payload());
            $id = $event->field('_uuid');
            $this->redis->rPush($id, $payload);
        }
    }
}
