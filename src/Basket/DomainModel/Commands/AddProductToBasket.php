<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel\Commands;

use Freyr\RPA\Basket\DomainModel\AggregateId;
use Freyr\RPA\Basket\DomainModel\ProductId;
use Ramsey\Uuid\UuidInterface;

class AddProductToBasket
{
    private int $amount;
    private ProductId $productId;
    private AggregateId $aggregateId;

    public function __construct(
        UuidInterface $aggregateId,
        UuidInterface $productId,
        int $amount
    )
    {
        $this->productId = new ProductId($productId);
        $this->aggregateId = new AggregateId($productId);
        $this->amount = $amount;
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId->id;
    }

    public function getAggregateId(): UuidInterface
    {
        return $this->aggregateId->id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
