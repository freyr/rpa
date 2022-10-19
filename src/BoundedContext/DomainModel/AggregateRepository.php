<?php

declare(strict_types=1);

namespace Freyr\RPA\BoundedContext\DomainModel;

use Ramsey\Uuid\UuidInterface;

interface AggregateRepository
{
    public function getById(UuidInterface $aggregateId): Aggregate;
    public function store(Aggregate $aggregate): void;
}
