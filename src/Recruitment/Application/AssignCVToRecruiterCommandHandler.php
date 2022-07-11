<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\Application;


use Freyr\RPA\Recruitment\DomainModel\Command\AssignCVToRecruiterCommand;
use Ramsey\Uuid\Uuid;

class AssignCVToRecruiterCommandHandler
{
    public function __invoke(AssignCVToRecruiterCommand $command)
    {

        $aggregate = $this->repository->getById($command->getId());

        $event = $aggregate->assign($command);
        $this->dispatcher->dispatch($event);
    }
}
