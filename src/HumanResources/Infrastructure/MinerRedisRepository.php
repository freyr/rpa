<?php

declare(strict_types=1);

namespace Freyr\RPA\HumanResources\Infrastructure;

use Freyr\RPA\HumanResources\DomainModel\Miner;
use Freyr\RPA\HumanResources\DomainModel\MinerRepository;
use Freyr\RPA\Section\DomainModel\Section;
use Freyr\RPA\Shared\AggregateChanged;
use Redis;

class MinerRedisRepository implements MinerRepository
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis-rpa');
    }

    public function load(string $id): Miner
    {
        $len = $this->redis->lLen($id);
        $data = $this->redis->lRange($id, 0, $len);
        $events = [];
        foreach ($data as $row) {
            $payload = json_decode($row, true);
            $class = $payload['_name'];
            $events[] = $class::fromArray($payload);

        }
        return Miner::fromStream($events);
    }

    public function store(Section $aggregate): void
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
