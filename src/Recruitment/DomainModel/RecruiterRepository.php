<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

interface RecruiterRepository
{

    public function getById(string $recruitmentId): Recruiter;

    public function persist(Recruiter $aggregate);

    /** @var Recruiter[] */
    public function getAll(): array;
}
