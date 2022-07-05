<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\ReadModel;

use DateTime;


class DefaultView implements \JsonSerializable
{

    private DateTime $createdOn;
    public function __construct()
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'created_on' => $this->createdOn->format(DateTime::ISO8601),
        ];
    }
}
