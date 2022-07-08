<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\Application;

use Freyr\RPA\Voting\DomainModel\Voting;
use Freyr\RPA\Voting\DomainModel\CreateVotingCommand;
use Freyr\RPA\Voting\DomainModel\VotingRepository;

class CreateVotingCommandHandler
{
    public function __construct(private VotingRepository $repository)
    {
    }


    public function __invoke(CreateVotingCommand $command)
    {
        $aggregate = Voting::createNew($command);
        $this->repository->store($aggregate);
    }
}
