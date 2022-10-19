<?php

declare(strict_types=1);

namespace Freyr\RPA\BoundedContext\DomainModel;

class ParkingSpacesBookingCalendar
{


    private array $listOfBookings = [];

    public function __construct()
    {
    }

    public static function new(Command\BookParkingSpaceCommand $command): self
    {
    }

    public function bookParkingSpace(Command\BookParkingSpaceCommand $command)
    {
        if ($isActive) {
            $range = new ReservationDateRange($command->from, $command->to);
            $locationId = $command->locationId;
            $userId = $command->userId;

            $this->listOfBookings->addNew(
                new ParkingSpaceBooking($command->locationId, $command->userId, $command->from, $command->to)
            );
        }
    }

    public function getListOfBookings(): array
    {
        return $this->listOfBookings;
    }
}
