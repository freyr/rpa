<?php

namespace Freyr\RPA\RRSO\Application;

use Freyr\RPA\RRSO\DomainModel\RRSOCalculationDomainService;
use Freyr\RPA\RRSO\DomainModel\RRSOCalculationQuery;

class ContractRrsoCalculatorQueryHandler
{
    public function __construct(private RRSOCalculationDomainService $service)
    {
    }

    public function __invoke(ContractRRSOCalculationQuery $calculation): ContractRRSODTO
    {
        $query = new RRSOCalculationQuery($calculation->getAmount());
        $value = $this->service->caluclate($query);
        return new ContractRRSODTO($value->getValue());
    }
}
