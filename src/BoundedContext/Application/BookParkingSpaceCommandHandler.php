<?php

declare(strict_types=1);

namespace Freyr\RPA\BoundedContext\Application;

use Freyr\RPA\BoundedContext\DomainModel\ParkingSpacesBookingCalendarRepository;
use Freyr\RPA\BoundedContext\DomainModel\Command\BookParkingSpaceCommand;
use Ramsey\Uuid\UuidInterface;

class BookParkingSpaceCommandHandler
{
    public function __construct(private ParkingSpacesBookingCalendarRepository $repository)
    {
    }

    public function __invoke(BookParkingSpaceCommand $command): UuidInterface
    {
        $parkingSpaceCalendar = $this->repository->getById($command->aggregateId);

        $parkingSpaceCalendar->bookParkingSpace($command);
        $this->repository->store($parkingSpaceCalendar);
    }
}
