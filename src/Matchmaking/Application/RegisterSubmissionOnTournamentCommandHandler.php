<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\Application;

use Exception;
use Freyr\RPA\Matchmaking\DomainModel\Commands\RegisterSubmissionOnTournament;
use Freyr\RPA\Matchmaking\DomainModel\Submission;
use Freyr\RPA\Matchmaking\Infrastructure\TournamentSubmissionRepository;

class RegisterSubmissionOnTournamentCommandHandler
{
    public function __construct(private TournamentSubmissionRepository $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(RegisterSubmissionOnTournament $command): void
    {
        $tournamentSubmissions = $this->repository->load($command->getTournamentId());
        $submission = new Submission($command->getSubmissionId(), $command->getParticipants());
        $tournamentSubmissions->processSubmission($submission);
        $this->repository->store($tournamentSubmissions);
    }
}
