<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\DomainModel\Commands;

use Ramsey\Uuid\UuidInterface;

class CreateTournament
{

    public function __construct(private UuidInterface $uuid, private string $name)
    {
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
