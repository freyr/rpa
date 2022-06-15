<?php

declare(strict_types=1);

namespace Freyr\RPA\RRSO\Application;

class ContractRRSODTO
{
    public function __construct(private float $value)
    {
    }

    public function getValue(): float
    {
        return $this->value;
    }


}
