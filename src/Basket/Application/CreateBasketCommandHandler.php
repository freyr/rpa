<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\Application;

use Freyr\RPA\Basket\DomainModel\Basket;
use Freyr\RPA\Basket\DomainModel\Commands\CreateBasket;
use Freyr\RPA\Basket\Infrastructure\BasketRedisRepository;

class CreateBasketCommandHandler
{
    public function __construct(
        private BasketRedisRepository $repository
    )
    {
    }

    public function __invoke(CreateBasket $command)
    {
        $aggregate = Basket::create($command);
        $this->repository->store($aggregate);
    }
}
