<?php

namespace Freyr\RPA\Contract\DomainModel\OfferExpirationStrategy;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\Offer;

class TimeOfferExpirationStrategy implements OfferExpirationStrategy
{

    public function shouldOfferBeExpired(Offer $offer): bool
    {
        // TODO: Implement shouldOfferBeExpired() method.
    }
}
