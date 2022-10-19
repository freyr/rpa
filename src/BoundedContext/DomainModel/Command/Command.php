<?php

declare(strict_types=1);

namespace Freyr\RPA\BoundedContext\DomainModel\Command;

use DateTimeImmutable;
use Freyr\RPA\BoundedContext\DomainModel\ReservationDateRange;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Command
{

    private ReservationDateRange $dateRange;

    public function __construct(
        public UuidInterface $aggregateId,
        public int $userId,
        public int $locationId,
        public DateTimeImmutable $from,
        public DateTimeImmutable $to
    )
    {
        $this->dateRange = new ReservationDateRange($from, $to);
    }
}
