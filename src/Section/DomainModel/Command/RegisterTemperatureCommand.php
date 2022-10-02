<?php

declare(strict_types=1);

namespace Freyr\RPA\Section\DomainModel\Command;

class RegisterTemperatureCommand
{

    public function __construct(private float $temperature)
    {
    }

    public function getPassId(): string
    {
        return '';
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }
}
