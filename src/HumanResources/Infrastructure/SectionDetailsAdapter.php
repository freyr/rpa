<?php

declare(strict_types=1);

namespace Freyr\RPA\HumanResources\Infrastructure;

use Freyr\RPA\HumanResources\ReadModel\SectionDetails;
use Freyr\RPA\HumanResources\ReadModel\SectionDetailsRepository;
use Freyr\RPA\Section\Application\HRSectionDetailsQueryHandler;

class SectionDetailsAdapter implements SectionDetailsRepository
{

    public function __construct(private HRSectionDetailsQueryHandler $handler)
    {
    }

    public function getById(string $sectionId): SectionDetails
    {
        $sectionDetails = ($this->handler)($sectionId);
        $hrSectionDetails  =new SectionDetails();
        //mapping to local section details

        return $hrSectionDetails;

    }
}
