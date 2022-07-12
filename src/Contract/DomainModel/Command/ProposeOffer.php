<?php

namespace Freyr\RPA\Contract\DomainModel\Command;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\OfferId;

class ProposeOffer
{

    public function getId(): OfferId
    {
        return OfferId::createNew('');
    }

    public function getApplicationCreatedTime(): Carbon
    {
        return new Carbon('now');
    }

    public function getAmount(): int
    {
        return 100;
    }

    public function getAge(): int
    {
    }

    public function getPeriod(): int
    {
    }
}
