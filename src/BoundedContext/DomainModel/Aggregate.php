<?php

declare(strict_types=1);

namespace Freyr\RPA\BoundedContext\DomainModel;

class Aggregate
{
    private $bookings = [
        1 => [
            ['userId' => 1, 'day' => 130],
            131,
            150,
        ],
        2 => [130, 131, 150,],
        3 => []
    ];

    private $blocked = [
        15 => 141
    ];

    public function __construct()
    {
    }

    public static function new(Command\Command $command): self
    {

    }

    public function bookParkingSpace(Command\Command $command)
    {
        $range = new ReservationDateRange($command->from, $command->to);
        $locationId = $command->locationId;
        $userId = $command->userId;
    }
}
