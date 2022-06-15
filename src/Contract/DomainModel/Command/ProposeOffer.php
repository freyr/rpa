<?php

namespace Freyr\RPA\Contract\DomainModel\Command;

use Freyr\RPA\Contract\DomainModel\OfferId;

class ProposeOffer
{

    public function getId(): OfferId
    {
        return OfferId::createNew('');
    }
}
