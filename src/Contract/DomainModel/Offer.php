<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\Command\ProposeOffer;
use Freyr\RPA\Contract\DomainModel\Event\OfferWasAccepted;
use Freyr\RPA\Contract\DomainModel\Event\OfferWasRejected;
use Freyr\RPA\Contract\DomainModel\Event\OfferWasCreated;
use Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification\BigClientLoanLimitation;
use Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification\IsItBigClientByValueOfLoans;
use Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification\OfferAcceptance;
use Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification\ProlongedOfferExpiration;
use Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification\SmallClientLoanLimitation;
use Freyr\RPA\Contract\DomainModel\OfferAcceptanceSpecification\StandardOfferExpiration;
use Freyr\RPA\RRSO\Application\ContractRRSODTO;
use Freyr\RPA\Shared\AggregateChanged;
use Freyr\RPA\Shared\AggregateRoot;

class Offer extends AggregateRoot
{
    private int $amount;
    private int $period;
    private int $age;
    private ContractRRSODTO $rrso;
    private bool $bail;
    private OfferId $id;
    private string $status;

    public function __construct()
    {
    }

    public function createNewOffer(ProposeOffer $command, ContractRRSODTO $rrso)
    {
        $id = $command->getId();
        $this->recordThat(
            OfferWasCreated::occur($id->uuid->toString(), [
                'age' => $command->getAge(),
                'period' => $command->getPeriod(),
                'status' => 'created'
            ])
        );

        // this is two part specification pattern
        // 1. data to calculate specification is collected in separate value object
        // 2. Check if the client is "big" is made to determine which specification should be applied
        // 3. Acceptance rules are verified to determine io offer can be accepted
        $offerExpirationInformation = new OfferAcceptance(
            15,
            5000000,
            Carbon::yesterday(),
            $command->getAmount()
        );

        // big client specification by two rules - number of loans or sum of loans
        $isBigClient = (new SmallClientLoanLimitation())->or(new IsItBigClientByValueOfLoans());
        if ($isBigClient->isSatisfiedBy($offerExpirationInformation) ) {
            // big client have different limitation of offer and value
            $canOfferBeAccepted = (new BigClientLoanLimitation())->and(new ProlongedOfferExpiration());
        } else {
            $canOfferBeAccepted = (new SmallClientLoanLimitation())->and(new StandardOfferExpiration());
        }

        // if acceptance rules are NOT satisfied then offer expires automatically
        if ($canOfferBeAccepted->isSatisfiedBy($offerExpirationInformation)) {
            $this->recordThat(OfferWasAccepted::occur($id->uuid->toString(), ['status' => 'accepted']));
        } else {
            $this->recordThat(OfferWasRejected::occur($id->uuid->toString(), ['status' => 'rejected']));
        }
    }

    public function aggregateId(): string
    {
        return $this->id->uuid->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        $class = get_class($event);
        $handler = match ($class) {
            OfferWasCreated::class => function (OfferWasCreated $event) {
                $this->whenOfferWasCreated($event);
            },
            OfferWasRejected::class => function (OfferWasRejected $event) {
                $this->whenOfferRejected($event);
            },
            OfferWasAccepted::class => function (OfferWasAccepted $event) {
                $this->whenOfferAccepted($event);
            },
        };

        $handler($event);
    }

    private function whenOfferWasCreated(OfferWasCreated $event)
    {
        $this->id = $event->field('_uuid');
        $this->status = $event->field('status');
        $this->amount = $event->field('amount');
        $this->period = $event->field('period');
        $this->age = $event->field('age');
        $this->rrso = $event->field('rrso');
        $this->bail = $event->field('bail');
    }

    private function whenOfferRejected(OfferWasRejected $event)
    {
        $this->bail = $event->field('status');
    }

    private function whenOfferAccepted(OfferWasAccepted $event)
    {
        $this->status = $event->field('status');
    }
}
