<?php

declare(strict_types=1);

namespace Freyr\RPA\Section\DomainModel;

interface SectionRepository
{
    public function load(string $id): Section;

    public function store(Section $aggregate): void;
}
