<?php

namespace Freyr\RPA\Contract\DomainModel\OfferExpirationStrategy;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\Offer;

class OfferExpirationStrategyFactory implements OfferExpirationStrategy
{
    private TimeOfferExpirationStrategy $timeOfferExpirationStrategy;
    private AmountOfferExpirationStrategy $amountOfferExpirationStrategy;

    public function __construct(
        TimeOfferExpirationStrategy $timeOfferExpirationStrategy,
        AmountOfferExpirationStrategy $amountOfferExpirationStrategy
    ) {
        $this->timeOfferExpirationStrategy = $timeOfferExpirationStrategy;
        $this->amountOfferExpirationStrategy = $amountOfferExpirationStrategy;
    }

    public function shouldOfferBeExpired(Offer $offer): bool
    {
        if ($offer->getAmmount() > 20000000) {
            return $this->amountOfferExpirationStrategy->shouldOfferBeExpired($offer);
        } else {
            return $this->timeOfferExpirationStrategy->shouldOfferBeExpired($offer);
        }
    }
}
