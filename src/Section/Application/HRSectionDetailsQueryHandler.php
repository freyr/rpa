<?php

declare(strict_types=1);

namespace Freyr\RPA\Section\Application;

use Freyr\RPA\Section\ReadModel\SectionDetails;

class HRSectionDetailsQueryHandler
{

    public function __invoke(): SectionDetails
    {
        return new SectionDetails();
    }
}
