<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification;

use Carbon\Carbon;

class OfferAcceptance
{

    public function __construct(
        private int $numberOfLoans,
        private float $valueOfLoans,
        private Carbon $offerCreation,
        private float $currentOfferLoanAmount
    )
    {
    }

    public function getNumberOfLoans(): int
    {
        return $this->numberOfLoans;
    }

    public function getValueOfLoans(): float
    {
        return $this->valueOfLoans;
    }

    public function getOfferCreation(): Carbon
    {
        return $this->offerCreation;
    }

    public function getCurrentOfferLoanAmount(): float
    {
        return $this->currentOfferLoanAmount;
    }
}
