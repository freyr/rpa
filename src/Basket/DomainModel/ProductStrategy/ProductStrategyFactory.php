<?php

namespace Freyr\RPA\Basket\DomainModel\ProductStrategy;

class ProductStrategyFactory implements ProductStrategy
{
    /** @var ProductStrategy[] */
    private array $strategies = [];

    public function addStrategy(ProductStrategy $strategy)
    {
        $this->strategies[] = $strategy;
    }

    public function isSatisfyBy(string $category, int $amount, float $price): bool
    {

        foreach ($this->strategies as $strategy)
        {
            if ($strategy->canHandle($category)) {
                return $strategy->isSatisfyBy($category, $amount, $price);
            }
        }
        //
    }

    public function canHandle(string $category)
    {
        // TODO: Implement canHandle() method.
    }
}
