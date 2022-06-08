<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\DomainModel;

use JsonSerializable;

class Participant implements JsonSerializable
{
    private int $membershipId;

    public function __construct(int $membershipId)
    {
        $this->membershipId = $membershipId;
    }

    public static function fromArray(mixed $participant): self
    {
        return new self($participant['membership_id']);
    }

    public function getMembershipId(): int
    {
        return $this->membershipId;
    }


    public function jsonSerialize(): array
    {
        return [
            'membership_id' => $this->membershipId
        ];
    }
}
