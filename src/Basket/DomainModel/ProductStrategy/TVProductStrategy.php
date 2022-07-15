<?php

namespace Freyr\RPA\Basket\DomainModel\ProductStrategy;

class TVProductStrategy implements ProductStrategy
{

    public function isSatisfyBy(string $category, int $amount, float $price): bool
    {
        return $amount < 10;
    }

    public function canHandle(string $category): bool
    {
        return $category === 'TV';
    }
}
