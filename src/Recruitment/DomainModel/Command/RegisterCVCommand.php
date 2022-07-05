<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel\Command;

use Freyr\RPA\Recruitment\DomainModel\Offer;
use Freyr\RPA\Recruitment\DomainModel\Pesel;

class RegisterCVCommand
{
    private Pesel $pesel;
    private string $name;
    private string $surname;
    private string $cvPath;
    private ?Offer $offer;

    public function getPesel(): Pesel
    {
        return $this->pesel;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getCvPath(): string
    {
        return $this->cvPath;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function getId(): string
    {
        return (string) $this->getPesel();
    }

}
