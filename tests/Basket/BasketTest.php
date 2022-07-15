<?php

namespace Tests\Basket;

use Freyr\RPA\Basket\Application\AddProductToBasketCommandHandler;
use Freyr\RPA\Basket\Application\CreateBasketCommandHandler;
use Freyr\RPA\Basket\Application\RemoveProductFromBasketCommandHandler;
use Freyr\RPA\Basket\DomainModel\Basket;
use Freyr\RPA\Basket\DomainModel\Commands\AddProductToBasket;
use Freyr\RPA\Basket\DomainModel\Commands\CreateBasket;
use Freyr\RPA\Basket\DomainModel\Commands\RemoveProductFromBasket;
use Freyr\RPA\Basket\Infrastructure\BasketRedisRepository;
use Freyr\RPA\Basket\Infrastructure\ProductSdkService;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class BasketTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function shouldCreate()
    {
        $repository = new BasketRedisRepository();
//        $handler = new CreateBasketCommandHandler($repository);
//        $command = new CreateBasket(Uuid::uuid4());
//        $handler($command);

        $basketId = '2223035e-3af0-477d-bbca-3cc396f53fdf';
        //41a12ac5-6f39-4183-adfc-5991ee0f3cfb


//        $productService = new ProductSdkService();
//        $handler = new AddProductToBasketCommandHandler($repository, $productService);
//        $command = new AddProductToBasket(
//            Uuid::fromString($basketId),
//            Uuid::fromString('41a12ac5-6f39-4183-adfc-5991ee0f3cfb'),
//            1,
//        );
//        $handler($command);

        $handler = new RemoveProductFromBasketCommandHandler($repository);
        $command = new RemoveProductFromBasket(
            Uuid::fromString($basketId),
            Uuid::fromString('41a12ac5-6f39-4183-adfc-5991ee0f3cfb'),
        );
        $handler($command);
    }
}
