<?php

namespace Freyr\RPA\Basket\DomainModel\ProductStrategy;

interface ProductStrategy
{
    public function isSatisfyBy(string $category, int $amount, float $price): bool;

    public function canHandle(string $category);
}
