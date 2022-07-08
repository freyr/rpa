<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\DomainModel;

class MajorityWinningStrategy extends WinningStrategy
{

    public function __construct()
    {
    }

    public function whoWon(int $for, int $against): bool
    {
        return $for > $against;
    }
}
