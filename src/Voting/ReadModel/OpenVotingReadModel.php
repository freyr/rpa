<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\ReadModel;


class OpenVotingReadModel implements \JsonSerializable
{

    public function jsonSerialize(): array
    {
        return [];
    }
}
