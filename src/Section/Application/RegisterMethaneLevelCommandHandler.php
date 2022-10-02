<?php

declare(strict_types=1);

namespace Freyr\RPA\Section\Application;

use Freyr\RPA\Section\DomainModel\SectionRepository;
use Freyr\RPA\Section\DomainModel\Command\RegisterTemperatureCommand;

class RegisterMethaneLevelCommandHandler
{

    public function __construct(private SectionRepository $aggregateRepository)
    {

    }

    public function __invoke(RegisterTemperatureCommand $command)
    {
        $aggregate = $this->aggregateRepository->load($command->getPassId());
        $aggregate->registerTemperature($command);
        $this->aggregateRepository->store($aggregate);
    }

}



