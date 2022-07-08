<?php

namespace Freyr\RPA\Voting\DomainModel;

abstract class WinningStrategy
{

    abstract public function whoWon(int $for, int $against): bool;
}
