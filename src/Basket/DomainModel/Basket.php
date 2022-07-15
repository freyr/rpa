<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel;

use Freyr\RPA\Basket\DomainModel\Commands\AddProductToBasket;
use Freyr\RPA\Basket\DomainModel\Commands\CreateBasket;
use Freyr\RPA\Basket\DomainModel\Commands\RemoveProductFromBasket;
use Freyr\RPA\Basket\DomainModel\Events\BasketWasCreated;
use Freyr\RPA\Basket\DomainModel\Events\ProductWasAddedToBasket;
use Freyr\RPA\Basket\DomainModel\Events\ProductWasRemovedFromBasket;
use Freyr\RPA\Basket\ReadModel\ProductService;
use Freyr\RPA\Shared\AggregateChanged;
use Freyr\RPA\Shared\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

class Basket extends AggregateRoot
{
    private string $id;
    /** @var string[] */
    private array $products = [];


    public static function create(CreateBasket $command): Basket
    {
        $self = new Basket();
        $self->recordThat(BasketWasCreated::occur($command->getAggregateId()->toString(), []));
        return $self;
    }

    public function removeProductFromBasket(RemoveProductFromBasket $command): void
    {
        $productId = (string) $command->getProductId();
        if (array_key_exists($productId, $this->products)) {
            $this->recordThat(ProductWasRemovedFromBasket::occur($this->id, [
                'productId' => $productId
            ]));
        }
    }

    public function addProductToBasket(AddProductToBasket $command, ProductService $productService): void
    {
        $product = $productService->getProduct(new ProductId($command->getProductId()));
        $productId = $command->getProductId()->toString();

        if ($command->getAmount() > 10) {
            return;
        }

        if (array_key_exists($productId, $this->products)) {
            $currentAmount = (int) $this->products[$productId]['amount'];
            if ($currentAmount + $command->getAmount() > 10) {
                return;
            }
        }

        $this->recordThat(ProductWasAddedToBasket::occur($this->id, [
            'productId' => $productId,
            'amount' => $command->getAmount(),
            'price' => $product->getPrice()
        ]));

    }

    public function aggregateId(): string
    {
        return (string) $this->id;
    }

    protected function apply(AggregateChanged $event): void
    {
        $class = get_class($event);
        $handler = match ($class) {
            ProductWasRemovedFromBasket::class => fn(ProductWasRemovedFromBasket $event) => $this->onProductWasRemovedFromBasket($event),
            ProductWasAddedToBasket::class => fn(ProductWasAddedToBasket $event) => $this->onProductWasAddedToBasket($event),
            BasketWasCreated::class => fn(BasketWasCreated $event) => $this->onBasketWasCreated($event),
        };

        $handler($event);
    }

    private function onProductWasRemovedFromBasket(ProductWasRemovedFromBasket $event)
    {
        unset($this->products[$event->field('productId')]);
    }

    private function onProductWasAddedToBasket(ProductWasAddedToBasket $event): void
    {
        $productId = $event->field('productId');
        $price = (float) $event->field('price');
        $amount = (int) $event->field('amount');
        if (array_key_exists($productId, $this->products)) {
            $currentAmount = (int) $this->products[$productId]['amount'];
            $this->products[$productId] = ['price' => $price, 'amount' => $currentAmount + $amount];
        } else {
            $this->products[$productId] = ['price' => $price, 'amount' => $amount];
        }
    }

    private function onBasketWasCreated(BasketWasCreated $event)
    {
        $this->id = $event->field('_uuid');
    }
}
