<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\Application;

use Freyr\RPA\Basket\DomainModel\Commands\CreateBasket;
use Freyr\RPA\Basket\DomainModel\ProductId;
use Freyr\RPA\Basket\Infrastructure\BasketRedisRepository;
use Freyr\RPA\Basket\ReadModel\ProductService;

class AddProductToBasketCommandHandler
{
    public function __construct(
        private BasketRedisRepository $repository,
        private ProductService $productService
    )
    {
    }

    public function __invoke(CreateBasket $command)
    {
        // load aggregate
        $aggregate = $this->repository->load($command->getAggregateId()->toString());

        // modify
        $aggregate->addProductToBasket($command, $this->productService);

        // persist
        $this->repository->store($aggregate);
    }
}
