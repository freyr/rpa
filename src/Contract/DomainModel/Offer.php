<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\Command\ProposeOffer;
use Freyr\RPA\Contract\DomainModel\Event\OfferExpired;
use Freyr\RPA\Contract\DomainModel\Event\OfferWasCreated;
use Freyr\RPA\Contract\DomainModel\OfferExpirationStrategy\OfferExpirationStrategy;
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
    private OfferExpirationStrategy $offerExpirationStrategy;

    public function __construct()
    {
    }

    public function setExpirationStrategy(OfferExpirationStrategy $offerExpirationStrategy)
    {
        $this->offerExpirationStrategy = $offerExpirationStrategy;
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

        if ($this->offerExpirationStrategy->shouldOfferBeExpired($this)) {
            $this->recordThat(OfferExpired::occur($id->uuid->toString(), ['status' => 'expired']));
        }
    }

    public function aggregateId(): string
    {
        // TODO: Implement aggregateId() method.
    }

    public function isClientBig(): bool
    {
        $numberOfLoans = new NumberOfLoans(15);
        $sumOfLoans = new SumOfLoans(5000000);
        $applicationDate = new ApplicationDate('');
        // implement by specification
        if ($numberOfLoans->and($sumOfLoans)->or($applicationDate)) {

        }
        return ($this->client->numberOdLoan > 15 && $this->client->sumOfLoans > 5000000 || $this->applicationCreatedTime < $now);
    }

    protected function apply(AggregateChanged $event): void
    {
        $class = get_class($event);
        $handler = match ($class) {
            OfferWasCreated::class => function (OfferWasCreated $event) {
                $this->whenOfferWasCreated($event);
            },
            OfferExpired::class => function (OfferExpired $event) {
                $this->whenOfferExpired($event);
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

    private function whenOfferExpired(OfferWasCreated $event)
    {
        $this->bail = $event->field('status');
    }
}
