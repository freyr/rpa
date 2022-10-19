<?php

declare(strict_types=1);

namespace Freyr\RPA\BoundedContext\DomainModel;

use Ramsey\Uuid\UuidInterface;

interface ParkingSpacesBookingCalendarRepository
{
    public function getById(UuidInterface $aggregateId): ParkingSpacesBookingCalendar;
    public function store(ParkingSpacesBookingCalendar $aggregate): void;
}
