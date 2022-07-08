<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\Application;

use Freyr\RPA\Voting\DomainModel\Voting;
use Freyr\RPA\Voting\DomainModel\CastVoteCommand;
use Freyr\RPA\Voting\DomainModel\VotingRepository;

class TimeLimitFinishVotingCommandHandler
{
    public function __construct(private VotingRepository $repository)
    {
    }


    public function __invoke(CastVoteCommand $command)
    {
        $aggregates = $this->repository->getAll();

        /** @var Voting $aggregate */
        foreach ($aggregates as $aggregate) {
            $aggregate->finishOnTimeLimit();
            $this->repository->store($aggregate);
        }

    }
}
