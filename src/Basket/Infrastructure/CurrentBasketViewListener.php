<?php

namespace Freyr\RPA\Basket\Infrastructure;

use Freyr\RPA\Basket\DomainModel\Events\BasketWasCreated;
use Freyr\RPA\Basket\DomainModel\Events\ProductWasAddedToBasket;
use Freyr\RPA\Basket\DomainModel\Events\ProductWasRemovedFromBasket;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CurrentBasketViewListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            BasketWasCreated::class => ['onBasketWasCreated', 90],
            ProductWasAddedToBasket::class => ['onProductWasAdded', 100],
            ProductWasRemovedFromBasket::class => ['onProductWasRemoved', 110],
        ];
    }

    public function onBasketWasCreated($event)
    {

    }

    public function onProductWasAdded($event)
    {

    }
}
