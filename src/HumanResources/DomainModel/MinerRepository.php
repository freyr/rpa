<?php

declare(strict_types=1);

namespace Freyr\RPA\HumanResources\DomainModel;

interface MinerRepository
{
    public function load(string $id): Miner;

    public function store(Miner $aggregate): void;
}
