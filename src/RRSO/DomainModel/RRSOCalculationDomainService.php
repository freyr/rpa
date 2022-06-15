<?php

declare(strict_types=1);

namespace Freyr\RPA\RRSO\DomainModel;

class RRSOCalculationDomainService
{

    public function caluclate(RRSOCalculationQuery $query): RRSOValue
    {
        return new RRSOValue();
    }
}
