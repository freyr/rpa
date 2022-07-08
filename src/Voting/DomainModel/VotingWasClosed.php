<?php

namespace Freyr\RPA\Voting\DomainModel;

use Ramsey\Uuid\UuidInterface;

class VotingWasClosed
{
    private bool $result;
    private UuidInterface $uuid;

    /**
     * @param bool $result
     * @param UuidInterface $uuid
     */
    public function __construct(bool $result, UuidInterface $uuid)
    {
        $this->result = $result;
        $this->uuid = $uuid;
    }

    /**
     * @return bool
     */
    public function isResult(): bool
    {
        return $this->result;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
