<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel\Event;

use Freyr\RPA\Shared\AggregateChanged;

class OfferWasCreated extends AggregateChanged
{

    public function __construct()
    {
    }
}
