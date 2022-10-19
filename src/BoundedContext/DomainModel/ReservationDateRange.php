<?php

namespace Freyr\RPA\BoundedContext\DomainModel;

class ReservationDateRange
{

    /**
     * @param DateTimeImmutable $from
     * @param DateTimeImmutable $to
     */
    public function __construct(\DateTimeImmutable $from, \DateTimeImmutable $to)
    {
    }

    public function isInRange(int $dayNumber): bool
    {

    }
}
