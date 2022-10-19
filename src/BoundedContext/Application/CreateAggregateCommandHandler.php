<?php

declare(strict_types=1);

namespace Freyr\RPA\BoundedContext\Application;

use Freyr\RPA\BoundedContext\DomainModel\AggregateRepository;
use Freyr\RPA\BoundedContext\DomainModel\Command\Command;
use Ramsey\Uuid\UuidInterface;

class CreateAggregateCommandHandler
{
    public function __construct(private AggregateRepository $repository)
    {
    }

    public function __invoke(Command $command): UuidInterface
    {
        $aggregate = $this->repository->getById($command->aggregateId);

        $aggregate->bookParkingSpace($command,);
        $this->repository->store($aggregate);
    }
}
