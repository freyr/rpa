<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\Infrastructure;

use Freyr\RPA\Basket\DomainModel\ProductId;
use Freyr\RPA\Basket\ReadModel\ProductDetails;
use Freyr\RPA\Basket\ReadModel\ProductService;

class ProductSdkService implements ProductService
{
    public function getProduct(ProductId $productId): ProductDetails
    {
        // curl
        // json_decode
        // static constructor
        // exeception
        return new ProductDetails();
    }
}
