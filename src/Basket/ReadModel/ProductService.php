<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\ReadModel;

use Freyr\RPA\Basket\DomainModel\ProductId;

interface ProductService
{
    /**
     * @param ProductId $productId
     * @return ProductDetails
     * @throws ProductNotFoundException
     */
    public function getProduct(ProductId $productId): ProductDetails;
}
