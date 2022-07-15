<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\Infrastructure;

use Freyr\RPA\Basket\DomainModel\Basket;
use Freyr\RPA\Basket\DomainModel\BasketRepository;
use Freyr\RPA\Shared\AggregateChanged;
use Redis;
use Symfony\Component\EventDispatcher\EventDispatcher;

class BasketRedisRepository implements BasketRepository
{

    private Redis $redis;

    public function __construct(private EventDispatcher $dispatcher)
    {
        $this->redis = new Redis();
        $this->redis->connect('redis-rpa');
    }

    public function load(string $id): Basket
    {
        $len = $this->redis->lLen($id);
        $data = $this->redis->lRange($id, 0, $len);
        $events = [];
        foreach ($data as $row) {
            $payload = json_decode($row, true);
            $class = $payload['_name'];
            $events[] = $class::fromArray($payload);

        }

        return Basket::fromStream($events);
    }

    public function store(Basket $aggregate): void
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};
        $events = $eventExtractor->call($aggregate);
        /** @var AggregateChanged $event */
        foreach ($events as $event) {
            $payload = json_encode($event->payload());
            $id = $event->field('_uuid');
            $this->redis->rPush($id, $payload);
            $this->dispatcher->dispatch($event);
        }
    }
}
