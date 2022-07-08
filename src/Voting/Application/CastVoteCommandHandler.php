<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\Application;

use Freyr\RPA\Voting\DomainModel\CastVoteCommand;
use Freyr\RPA\Voting\DomainModel\VotingRepository;

class CastVoteCommandHandler
{
    public function __construct(private VotingRepository $repository)
    {
    }


    public function __invoke(CastVoteCommand $command)
    {
        $aggregate = $this->repository->getByUUid($command->getAggregateUuid());
        $aggregate->castVote($command);
        $this->repository->store($aggregate);
    }
}
