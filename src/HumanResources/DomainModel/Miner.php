<?php

declare(strict_types=1);

namespace Freyr\RPA\HumanResources\DomainModel;

use Freyr\RPA\HumanResources\DomainModel\Command\AssignMinerToSectionCommand;
use Freyr\RPA\HumanResources\ReadModel\SectionDetails;
use Freyr\RPA\Shared\AggregateChanged;
use Freyr\RPA\Shared\AggregateRoot;

class Miner extends AggregateRoot
{

    public function assign(
        AssignMinerToSectionCommand $command,
        SectionDetails $sectionDetails
    ): void
    {

    }

    public function aggregateId(): string
    {
        // TODO: Implement aggregateId() method.
    }

    protected function apply(AggregateChanged $event): void
    {
        // TODO: Implement apply() method.
    }
}
