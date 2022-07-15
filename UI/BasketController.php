<?php

use Freyr\RPA\Basket\Application\CreateBasketCommandHandler;
use Freyr\RPA\Basket\DomainModel\Commands\CreateBasket;
use Freyr\RPA\Basket\DomainModel\Commands\RemoveProductFromBasket;
use Freyr\RPA\Basket\Infrastructure\BasketRedisRepository;
use Ramsey\Uuid\Uuid;

class BasketController
{

    public function __construct(private Bus $bus)
    {
    }

    public function createBasket(Request $request, Response $response): Response
    {
        $basketId = Uuid::uuid4();
        $repository = new BasketRedisRepository();
        $command = new CreateBasket($basketId);
        $handler = new CreateBasketCommandHandler($repository);
        $handler($command);

        return $response->withStatus(200);
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
        (new CreateBasketCommandHandler())($command);
        return $response->withStatus(200);
    }
}
