<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\DomainModel;

use Ramsey\Uuid\UuidInterface;

interface VotingRepository
{

    public function store(Voting $aggregate): void;

    public function getByUUid(UuidInterface $getAggregateUuid): Voting;
}
