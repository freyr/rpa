<?php

declare(strict_types=1);

namespace Freyr\RPA\Contract\DomainModel;

use Carbon\Carbon;
use Freyr\RPA\Contract\DomainModel\Command\ProposeOffer;
use Freyr\RPA\Contract\DomainModel\Event\OfferExpired;
use Freyr\RPA\Contract\DomainModel\Event\OfferWasCreated;
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

    public function __construct()
    {
    }

    public function createNewOffer(ProposeOffer $command, ContractRRSODTO $rrso)
    {
        $id = $command->getId();
        if ($command->getApplicationCreatedTime() > (new Carbon('now'))->addDays(7)) {
            $this->recordThat(OfferExpired::occur($id->uuid->toString(), []));
        } else {
            $this->recordThat(
                OfferWasCreated::occur($id->uuid->toString(), [
                    'age' => $command->getAge(),
                    'period' => $command->getPeriod(),
                ])
            );
        }
    }

    public function aggregateId(): string
    {
        // TODO: Implement aggregateId() method.
    }

    protected function apply(AggregateChanged $event): void
    {
        $class = get_class($event);
        $handler = match ($class) {
            OfferWasCreated::class => function (OfferWasCreated $event) {$this->whenOfferWasCreated($event);},
        };

        $handler($event);
    }

    private function whenOfferWasCreated(OfferWasCreated $event)
    {
        $this->id = $event->field('_uuid');
        $this->amount = $event->field('amount');
        $this->period = $event->field('period');
        $this->age = $event->field('age');
        $this->rrso = $event->field('rrso');
        $this->bail = $event->field('bail');
    }
}
