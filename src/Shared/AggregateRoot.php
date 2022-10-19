<?php

declare(strict_types=1);

namespace Freyr\RPA\Shared;

abstract class AggregateRoot
{
    private array $events = [];

    public static function fromStream(array $streamEvents): self
    {
        $instance = new static();
        $instance->replay($streamEvents);

        return $instance;
    }

    protected function popRecordedEvents(): array
    {
        $pendingEvents = $this->events;

        $this->events = [];

        return $pendingEvents;
    }

    protected function replay(array $historyEvents): void
    {
        /** @var AggregateChanged $pastEvent */
        foreach ($historyEvents as $pastEvent) {
            $this->apply($pastEvent);
        }
    }

    protected function recordThat(AggregateChanged $event): void
    {
        $this->events[] = $event;
        $this->apply($event);
    }

    abstract public function aggregateId(): string;
    abstract protected function apply(AggregateChanged $event): void;
}
