<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel;

use Ramsey\Uuid\Uuid;

class OfferId
{
    private function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid);
    }

    public static function createNew(string $uuid): self
    {
        return new self($uuid);
    }

    public function equals(OfferId $aggregateId): bool
    {
        return $this->uuid->equals($aggregateId->uuid);
    }
}
