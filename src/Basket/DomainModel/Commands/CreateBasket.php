<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel\Commands;

use Freyr\RPA\Basket\DomainModel\BasketId;
use Ramsey\Uuid\UuidInterface;

class CreateBasket
{
    private BasketId $aggregateId;

    public function __construct(
        UuidInterface $aggregateId,
    )
    {
        $this->aggregateId = new BasketId($aggregateId);
    }

    public function getAggregateId(): UuidInterface
    {
        return $this->aggregateId->id;
    }
}
