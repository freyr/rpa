<?php

namespace Freyr\RPA\BoundedContext\DomainModel;

class ParkingSpaceBooking
{

    /**
     * @param int $userId
     * @param int $locationId
     * @param \DateTimeImmutable $from
     * @param \DateTimeImmutable $to
     */
    public function __construct(int $userId, int $locationId, \DateTimeImmutable $from, \DateTimeImmutable $to)
    {
    }
}
