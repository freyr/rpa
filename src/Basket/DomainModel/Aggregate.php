<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel;

use Freyr\RPA\Basket\DomainModel\Events\ProductWasRemovedFromBasket;
use Ramsey\Uuid\UuidInterface;

class Aggregate
{
    private UuidInterface $id;
    /** @var string[] */
    private array $products;

    public function removeProduct(ProductId $productId): void
    {
        $key = $productId->id->toString();
        if (array_key_exists($key, $this->products)) {
            unset($this->products[$key]);
            ProductWasRemovedFromBasket::occur($this->id->toString(), [
                'x'
            ]);
        }
    }
}
