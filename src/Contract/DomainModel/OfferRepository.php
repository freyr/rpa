<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel;

interface OfferRepository
{
    public function getById(OfferId $id): Offer;

    public function persist(Offer $aggregate): void;
}
