<?php

namespace Freyr\RPA\Contract\Infrastructure;

use Freyr\RPA\Contract\DomainModel\Offer;
use Freyr\RPA\Contract\DomainModel\OfferId;
use Freyr\RPA\Contract\DomainModel\OfferRepository;
use Freyr\RPA\Shared\AggregateChanged;
use Redis;

class OfferRedisRepository implements OfferRepository
{
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
        $this->redis->connect('localhost');
    }

    public function getById(OfferId $id): Offer
    {
        $len = $this->redis->lLen($id->uuid->toString());
        $data = $this->redis->lRange($id->uuid->toString(), 0, $len);
        $events = [];
        foreach ($data as $row) {
            $payload = json_decode($row, true);
            $class = $payload['_name'];
            $events[] = $class::fromArray($payload);

        }
        return Offer::fromStream($events);
    }

    public function persist(Offer $aggregate): void
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
