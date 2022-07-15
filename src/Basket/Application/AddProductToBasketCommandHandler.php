<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\Application;

use Freyr\RPA\Basket\DomainModel\Commands\AddProductToBasket;
use Freyr\RPA\Basket\Infrastructure\AggregateRedisRepository;

class AddProductToBasketCommandHandler
{
    public function __construct(private AggregateRedisRepository $repository)
    {
    }

    public function __invoke(AddProductToBasket $command)
    {
        // load aggregate
        $aggregate = $this->repository->load($command->getAggregateId()->toString());

        // modify
        $aggregate->addProductToBasket($command);

        // persist
        $this->repository->store($aggregate);
    }
}
