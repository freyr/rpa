<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel\OfferExpirationStrategy;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\Offer;

interface OfferExpirationStrategy
{
    public function shouldOfferBeExpired(Offer $offer): bool;
}
