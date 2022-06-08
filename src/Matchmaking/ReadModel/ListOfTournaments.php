<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\ReadModel;

use IteratorAggregate;
use Ramsey\Uuid\UuidInterface;
use Traversable;

class ListOfTournaments implements IteratorAggregate
{

    private array $tournaments;

    public function add(UuidInterface $uuid, string $name): void
    {
        $this->tournaments[] = [$uuid->toString(), $name];
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->tournaments);
    }
}
