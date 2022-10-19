<?php

namespace Freyr\RPA\BoundedContext\Infrastructure;

use Cassandra\Collection;
use Freyr\RPA\BoundedContext\DomainModel\ParkingSpaceBooking;
use Freyr\RPA\BoundedContext\DomainModel\ParkingSpacesBookingCalendar;
use Freyr\RPA\BoundedContext\DomainModel\ParkingSpacesBookingCalendarRepository;
use Ramsey\Uuid\UuidInterface;

class ParkingSpacesBookingCalendarRedisRepository
    implements ParkingSpacesBookingCalendarRepository
{

    public function getById(UuidInterface $aggregateId): ParkingSpacesBookingCalendar
    {
        // sql
        $result = [];
        $items = new Collection();
        foreach ($result as $book) {
            $items->add(new ParkingSpaceBooking());
        }
        return new ParkingSpacesBookingCalendar($items);
    }

    public function store(ParkingSpacesBookingCalendar $aggregate): void
    {
        $book = $aggregate->getListOfBookings();
        foreach ($book as $item) {
            $item->
        }
    }
}
