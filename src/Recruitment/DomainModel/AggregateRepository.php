<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

interface AggregateRepository
{

    public function getById(): Candidate;

    public function persist(Candidate $aggregate);
}
