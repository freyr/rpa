<?php

declare(strict_types=1);

namespace Tests\Matchmaking;

use Exception;
use Freyr\RPA\Matchmaking\DomainModel\Commands\RegisterSubmissionOnTournament;
use Freyr\RPA\Matchmaking\Application\RegisterSubmissionOnTournamentCommandHandler;
use Freyr\RPA\Matchmaking\DomainModel\Participant;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Redis;

class MatchmakingTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function simulateCommandFlowForSubmission()
    {

    }
}
