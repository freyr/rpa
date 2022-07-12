<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification;

use Carbon\Carbon;
use Freyr\RPA\Shared\Specification\Specification;

class ProlongedOfferExpiration extends Specification
{
    public function isSatisfiedBy($object): bool
    {
        /** @var Carbon $object */
        $expirationDate = $object->addDays(60);
        return $expirationDate > new Carbon('now');
    }
}
