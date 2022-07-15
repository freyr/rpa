<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel;

use Freyr\RPA\Basket\DomainModel\Commands\AddProductToBasket;
use Freyr\RPA\Basket\DomainModel\Commands\RemoveProductFromBasket;
use Freyr\RPA\Basket\DomainModel\Events\ProductWasRemovedFromBasket;
use Freyr\RPA\Shared\AggregateChanged;
use Freyr\RPA\Shared\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

class Aggregate extends AggregateRoot
{
    private UuidInterface $id;
    /** @var string[] */
    private array $products;

    public function removeProduct(RemoveProductFromBasket $command): void
    {
        $productId = (string) $command->getProductId();
        if (array_key_exists($productId, $this->products)) {
            $this->recordThat(ProductWasRemovedFromBasket::occur($this->id->toString(), [
                'productId' => $productId
            ]));
        }
    }

    public function addProductToBasket(AddProductToBasket $command): void
    {

    }

    public function aggregateId(): string
    {
        return (string) $this->id;
    }

    protected function apply(AggregateChanged $event): void
    {
        $class = get_class($event);
        $handler = match ($class) {
            ProductWasRemovedFromBasket::class => fn(ProductWasRemovedFromBasket $event) => $this->onProductWasRemovedFromBasket($event)
        };

        $handler($event);
    }

    private function onProductWasRemovedFromBasket(ProductWasRemovedFromBasket $event)
    {
        unset($this->products[$event->field('productId')]);
    }
}
