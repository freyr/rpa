<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\ReadModel\Queries;

class TournamentsQuery
{

    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
