<?php

declare(strict_types=1);

namespace Freyr\RPA\Section\Infrastructure;

use Freyr\RPA\Section\DomainModel\Section;
use Freyr\RPA\Section\DomainModel\SectionRepository;
use Freyr\RPA\Shared\AggregateChanged;
use Redis;

class SectionRedisRepository implements SectionRepository
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis-rpa');
    }

    public function load(string $id): Section
    {
        $len = $this->redis->lLen($id);
        $data = $this->redis->lRange($id, 0, $len);
        $events = [];
        foreach ($data as $row) {
            $payload = json_decode($row, true);
            $class = $payload['_name'];
            $events[] = $class::fromArray($payload);

        }
        return Section::fromStream($events);
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
