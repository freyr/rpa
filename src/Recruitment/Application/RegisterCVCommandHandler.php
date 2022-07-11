<?php

namespace Freyr\RPA\Recruitment\Application;

use Freyr\RPA\Recruitment\DomainModel\Candidate;
use Freyr\RPA\Recruitment\DomainModel\AggregateRepository;
use Freyr\RPA\Recruitment\DomainModel\Command\RegisterCVCommand;
use Freyr\RPA\Recruitment\DomainModel\Event\NewCandidateWasCreated;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcher;

class RegisterCVCommandHandler
{
    public function __construct(private AggregateRepository $repository, private EventDispatcher $dispatcher )
    {
    }

    public function __invoke(RegisterCVCommand $command)
    {
        if ($this->repository->exists($command->getId())) {
            $aggregate = $this->repository->getById($command->getId());
        } else {
            $aggregate = new Candidate(Uuid::uuid4());
            $event = new NewCandidateWasCreated();
            $this->dispatcher->dispatch($event);
        }

        $event = $aggregate->registerCV($command);
        $this->dispatcher->dispatch($event);

    }
}
