<?php

namespace Freyr\RPA\Recruitment\Infrastructure;

use Freyr\RPA\Recruitment\DomainModel\AggregateRepository;
use Freyr\RPA\Recruitment\DomainModel\Candidate;

class AggregateRedisRepository implements AggregateRepository
{

    public function getById(): Candidate
    {
        // TODO: Implement getById() method.
    }

    public function persist(Candidate $aggregate)
    {
        // TODO: Implement persist() method.
    }
}
