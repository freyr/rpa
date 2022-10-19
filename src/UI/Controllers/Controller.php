<?php

declare(strict_types=1);

namespace Freyr\RPA\UI\Controllers;

use Freyr\RPA\BoundedContext\Application\BookParkingSpaceCommandHandler;
use Freyr\RPA\BoundedContext\DomainModel\Command\BookParkingSpaceCommand;

class Controller
{

    public function create($request): void
    {
        $command = new BookParkingSpaceCommand(1, 10, new \DateTimeImmutable(), new \DateTimeImmutable());
        $handler = new BookParkingSpaceCommandHandler();
        $handler($command);
    }
}
