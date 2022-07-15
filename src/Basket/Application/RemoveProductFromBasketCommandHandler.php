<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\Application;

use Freyr\RPA\Basket\DomainModel\Commands\RemoveProductFromBasket;
use Freyr\RPA\Basket\Infrastructure\AggregateRedisRepository;

class RemoveProductFromBasketCommandHandler
{
    public function __construct(private AggregateRedisRepository $repository)
    {
    }

    public function __invoke(RemoveProductFromBasket $command)
    {
        // load aggregate
        $aggregate = $this->repository->load($command->getAggregateId()->toString());

        // modify
        $aggregate->removeProduct($command);

        // persist
        $this->repository->store($aggregate);
    }
}
