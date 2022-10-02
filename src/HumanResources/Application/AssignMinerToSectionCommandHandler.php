<?php

declare(strict_types=1);

namespace Freyr\RPA\HumanResources\Application;

use Freyr\RPA\HumanResources\DomainModel\Command\AssignMinerToSectionCommand;
use Freyr\RPA\HumanResources\DomainModel\MinerRepository;

class AssignMinerToSectionCommandHandler
{
    public function __construct(
        private MinerRepository $repository,
        private GetSectionDetailsQueryHandler $sectionHandler
    )
    {
    }

    public function __invoke(AssignMinerToSectionCommand $command)
    {
        $sectionDetails = ($this->sectionHandler)($command->getSectionId());
        $miner = $this->repository->load($command->getMinerId());
        $miner->assign($command, $sectionDetails);


    }
}
