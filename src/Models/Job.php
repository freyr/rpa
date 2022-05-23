<?php

namespace Freyr\RPA\Models;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Job implements JsonSerializable
{
    public function __construct(
        private int $id,
        private string $name,
        private string $type,
        private int $ownerId,
        private string $definition,
        private string $parameters,
        private int $environmentId,
        private int $destinationId,
        private string $status
    )
    {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getDestinationId(): int
    {
        return $this->destinationId;
    }

    /**
     * @param int $destinationId
     */
    public function setDestinationId(int $destinationId): void
    {
        $this->destinationId = $destinationId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @param int $ownerId
     */
    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return $this->definition;
    }

    /**
     * @param string $definition
     */
    public function setDefinition(string $definition): void
    {
        $this->definition = $definition;
    }

    /**
     * @return string
     */
    public function getParameters(): string
    {
        return $this->parameters;
    }

    /**
     * @param string $parameters
     */
    public function setParameters(string $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getEnvironmentId(): int
    {
        return $this->environmentId;
    }

    /**
     * @param int $environmentId
     */
    public function setEnvironmentId(int $environmentId): void
    {
        $this->environmentId = $environmentId;
    }

    #[ArrayShape([
        'id' => "int",
        'owner' => "int",
        'name' => "string",
        'type' => 'string',
        'definition' => "string",
        'parameters' => "string",
        'environmentId' => 'int',
        'destinationId' => 'int',
        'status' => "string"
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'owner' => $this->ownerId,
            'name' => $this->name,
            'type' => $this->type,
            'definition' => $this->definition,
            'parameters' => $this->parameters,
            'environmentId' => $this->environmentId,
            'destinationId' => $this->destinationId,
            'status' => $this->status
        ];
    }
}
