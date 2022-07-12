<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification;

use Freyr\RPA\Shared\Specification\Specification;

class IsItBigClientByNumberOfLoans extends Specification
{
    /**
     * @param OfferAcceptance $object
     * @return bool
     */
    public function isSatisfiedBy($object): bool
    {
        return $object->getNumberOfLoans() > 25;
    }
}
