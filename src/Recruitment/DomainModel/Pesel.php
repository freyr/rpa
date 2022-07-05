<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

class Pesel
{
    private string $pesel;

    public function __toString(): string
    {
        return $this->pesel;
    }
}
