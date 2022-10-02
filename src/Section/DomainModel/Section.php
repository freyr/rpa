<?php

declare(strict_types=1);

namespace Freyr\RPA\Section\DomainModel;

use Freyr\RPA\Section\DomainModel\Command\RegisterTemperatureCommand;
use Freyr\RPA\Section\DomainModel\Event\BoundaryTemperatureWasExeeded;
use Freyr\RPA\Section\DomainModel\Event\CriticalTemperatureWasExeeded;
use Freyr\RPA\Section\DomainModel\Event\TemperatureWasNormal;
use Freyr\RPA\Shared\AggregateChanged;
use Freyr\RPA\Shared\AggregateRoot;

class Section extends AggregateRoot
{

    private float $temperature;
    private float $minTemperature;
    private float $maxTemperature;

    public function registerTemperature(RegisterTemperatureCommand $command): void
    {
        $payload = [
            'temperature' => $this->temperature,
            'max-temperature' => $this->maxTemperature,
            'min-temperature' => $this->minTemperature,
        ];

        $temperature = $command->getTemperature();
        if ($temperature > $this->maxTemperature) {
            $payload['max-temperature'] = $temperature;
        }

        if ($temperature < $this->minTemperature) {
            $payload['min-temperature'] = $temperature;
        }

        $payload['temperature'] = $temperature;
        if ($temperature >= 28 && $temperature < 30) {
            $event = new BoundaryTemperatureWasExeeded(
                $this->aggregateId(), $payload
            );
        } elseif ($temperature >= 30) {
            $event = new CriticalTemperatureWasExeeded($this->aggregateId(), $payload);
        } else {
            $event = new TemperatureWasNormal($this->aggregateId(), $payload);
        }
        $this->recordThat($event);
    }

    public function aggregateId(): string
    {
        // TODO: Implement aggregateId() method.
    }

    protected function apply(AggregateChanged $event): void
    {
        $this->temperature = $event->field('temperature');
        $this->maxTemperature = $event->field('max-temperature');
        $this->minTemperature = $event->field('min-temperature');
    }


}
