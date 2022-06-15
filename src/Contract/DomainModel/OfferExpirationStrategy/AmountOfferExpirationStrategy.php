<?php

namespace Freyr\RPA\Contract\DomainModel\OfferExpirationStrategy;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\Offer;

class AmountOfferExpirationStrategy implements OfferExpirationStrategy
{
    private OfferExpirationStrategy $strategy;

    public function __construct(OfferExpirationStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function shouldOfferBeExpired(Offer $offer): bool
    {
        if ($offer->isClientBig()) {

        } else {
            $this->strategy->shouldOfferBeExpired($offer);
        }
    }
}
