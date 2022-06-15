<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\Application;

use Freyr\RPA\Contract\DomainModel\Offer;
use Freyr\RPA\Contract\DomainModel\OfferRepository;
use Freyr\RPA\Contract\DomainModel\Command\ProposeOffer;
use Freyr\RPA\RRSO\Application\ContractRRSOCalculationQuery;
use Freyr\RPA\RRSO\Application\ContractRrsoCalculatorQueryHandler;

class ProposeOfferCommandHandler
{
    public function __construct(
        private OfferRepository $repository,
        private ContractRrsoCalculatorQueryHandler $rrsoCalculatorQueryHandler
    ) {
    }

    public function __invoke(ProposeOffer $command): void
    {
        $rrso = ($this->rrsoCalculatorQueryHandler)(new ContractRRSOCalculationQuery());
        $aggregate = new Offer();
        $aggregate->createNewOffer($command, $rrso);
        $this->repository->persist($aggregate);
    }
}
