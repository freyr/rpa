<?php

declare(strict_types=1);

namespace Freyr\RPA\HumanResources\ReadModel;

interface SectionDetailsRepository
{
    public function getById(string $sectionId): SectionDetails;
}
