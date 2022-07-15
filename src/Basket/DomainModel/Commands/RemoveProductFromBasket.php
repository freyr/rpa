<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel\Commands;

use Freyr\RPA\Basket\DomainModel\AggregateId;
use Freyr\RPA\Basket\DomainModel\ProductId;
use Ramsey\Uuid\UuidInterface;

class RemoveProductFromBasket
{
    private ProductId $productId;
    private AggregateId $aggregateId;

    public function __construct(UuidInterface $aggregateId, UuidInterface $productId)
    {
        $this->productId = new ProductId($productId);
        $this->aggregateId = new AggregateId($productId);
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId->id;
    }

    public function getAggregateId(): UuidInterface
    {
        return $this->aggregateId->id;
    }


}
