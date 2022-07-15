<?php

declare(strict_types=1);

namespace Freyr\RPA\Basket\DomainModel;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class BasketId
{

    public static function create()
    {
        return new self(Uuid::uuid4());
    }

    public function __construct(readonly public UuidInterface $id)
    {
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }
}
