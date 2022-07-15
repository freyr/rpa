<?php

use Freyr\RPA\Basket\Application\AddProductToBasketCommandHandler;
use Freyr\RPA\Basket\DomainModel\Commands\RemoveProductFromBasket;
use Ramsey\Uuid\Uuid;

class BasketController
{

    public function __construct(private Bus $bus)
    {
    }

    public function removeProductFromBasket(Request $request, Response $response): Response
    {
        $aggregateid = $request->query['aggregateId'];
        $productId = $request->query['productId'];

        $command = new RemoveProductFromBasket(
            Uuid::fromString($aggregateid),
            Uuid::fromString($productId)
        );

        $this->bus->handle($command);
        (new AddProductToBasketCommandHandler())($command);
        return $response->withStatus(200);
    }
}
