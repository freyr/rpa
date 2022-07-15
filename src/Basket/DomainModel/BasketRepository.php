<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel;

interface BasketRepository
{
    public function load(string $id): Basket;

    public function store(Basket $aggregate): void;
}
