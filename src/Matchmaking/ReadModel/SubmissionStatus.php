<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\ReadModel;

use JsonSerializable;

class SubmissionStatus implements JsonSerializable
{
    public function __construct(private int $membershipId, private ?int $secondMembershipId)
    {
    }


    public function jsonSerialize(): array
    {
        return [
            'isCompleted' => !$this->membershipId,
            'members' => [
                $this->membershipId,
                $this->secondMembershipId || '-',
            ]
        ];
    }
}
