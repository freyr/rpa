<?php

namespace Freyr\RPA\Shared;

use DateTimeImmutable;
use DateTimeZone;
use ReflectionClass;

class AggregateChanged
{
    protected array $payload = [];

    public static function occur(string $aggregateId, array $payload = []): self
    {
        return new static($aggregateId, $payload);
    }

    public function __construct(string $aggregateId, array $payload = [])
    {
        $this->payload = $payload;
        $this->payload['_uuid'] = $aggregateId;
        $this->payload['_name'] = get_called_class();
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->payload['_occurred_on'] = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }

    public static function fromArray(array $messageData): AggregateChanged
    {
        $messageRef = new ReflectionClass(get_called_class());
        /** @var AggregateChanged $message */
        /** @noinspection PhpUnhandledExceptionInspection */
        $message = $messageRef->newInstanceWithoutConstructor();
        $message->payload = $messageData;

        return $message;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function field($key)
    {
        return $this->payload[$key];
    }
}
