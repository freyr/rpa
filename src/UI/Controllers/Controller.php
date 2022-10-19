<?php

declare(strict_types=1);

namespace Freyr\RPA\UI\Controllers;

use Freyr\RPA\BoundedContext\Application\CreateAggregateCommandHandler;
use Freyr\RPA\BoundedContext\DomainModel\Command\Command;

class Controller
{

    public function create($request): void
    {
        $command = new Command(1, 10, new \DateTimeImmutable(), new \DateTimeImmutable());
        $handler = new CreateAggregateCommandHandler();
        $handler($command);
    }
}
