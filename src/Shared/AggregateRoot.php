<?php

namespace Freyr\RPA\Shared;

class AggregateRoot
{
    private array $events = [];

    protected function popRecordedEvents(): array
    {
        $pendingEvents = $this->events;

        $this->events = [];

        return $pendingEvents;
    }
}
