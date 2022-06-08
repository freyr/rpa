<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\Application;

use Freyr\RPA\Matchmaking\DomainModel\Commands\CreateTournament;
use Freyr\RPA\Matchmaking\DomainModel\TournamentSubmissions;
use Freyr\RPA\Matchmaking\Infrastructure\TournamentSubmissionRepository;


class CreateTournamentCommandHandler
{
    public function __construct(private TournamentSubmissionRepository $repository)
    {

    }

    public function __invoke(CreateTournament $command): void
    {
        // crate new aggregate
        // this will automatically validate input and check all necessary business constraints.
        $tournament = new TournamentSubmissions($command->getUuid(), $command->getName(), [], []);

        // this is persisting layer.
        $this->repository->store($tournament);

        // this is "side-effect" call that will update any / all required projection
        // those could be any read-models, external services call or asynchronous event notification
        $this->repository->addToTournamentListProjection($tournament);
    }
}
