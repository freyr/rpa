<?php

namespace Tests\Voting;

use Exception;
use Freyr\RPA\Voting\Application\TimeLimitFinishVotingCommandHandler;
use Freyr\RPA\Voting\Application\CreateVotingCommandHandler;
use Freyr\RPA\Voting\DomainModel\CastVoteCommand;
use Freyr\RPA\Voting\DomainModel\CreateVotingCommand;
use Freyr\RPA\Voting\DomainModel\MajorityWinningStrategy;
use Freyr\RPA\Voting\DomainModel\Voting;
use Freyr\RPA\Voting\Infrastructure\VotingRedisRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class VotingTest extends TestCase
{

    /**
     * @test
     * @throws Exception
     */
    public function shouldCreateVoting()
    {
        $uuid = Uuid::uuid4();
        $name = 'sdfsdfs';
        $winningStrategy = new MajorityWinningStrategy();
        $command = new CreateVotingCommand($uuid, $name, $winningStrategy, 15);
        $repository = new VotingRedisRepository();
        $commandHandler = new CreateVotingCommandHandler($repository);
        $commandHandler($command);



        $command = new CastVoteCommand($uuid, Uuid::uuid4(), true);
        $repository = new VotingRedisRepository();
        $commandHandler = new TimeLimitFinishVotingCommandHandler($repository);
        $commandHandler($command);



    }

    /** @test */
    public function checkAggregate()
    {
        $voting = Voting::createNew();
        $voting->castVote();
        self::assertTrue();
    }
}
