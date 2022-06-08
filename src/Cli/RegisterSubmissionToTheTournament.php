<?php

declare(strict_types=1);

namespace Freyr\RPA\Cli;

use Carbon\Carbon;
use Exception;
use Freyr\RPA\Matchmaking\DomainModel\Commands\RegisterSubmissionOnTournament;
use Freyr\RPA\Matchmaking\Application\RegisterSubmissionOnTournamentCommandHandler;
use Freyr\RPA\Matchmaking\DomainModel\Participant;
use Freyr\RPA\Matchmaking\Infrastructure\TournamentSubmissionRepository;
use Ramsey\Uuid\Uuid;
use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class RegisterSubmissionToTheTournament extends Command
{

    protected function configure(): void
    {
        $this->setName('submission:register');
        $this->addArgument('tournamentId', InputArgument::REQUIRED, 'Id of an tournament (uuid) call tournament:create and tournament:list to get one');
        $this->addArgument('membershipCardId', InputArgument::REQUIRED, 'Id of an membership card (integer, 4 numbers)');
        $this->addArgument('optionalMembershipCardId', InputArgument::OPTIONAL, 'Second (optional) id of an membership card (integer, 4 numbers)');
    }

    /**
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $cardId = (int) $input->getArgument('membershipCardId');
        $optionalCardId = (int) $input->getArgument('optionalMembershipCardId');
        $tournamentId = Uuid::fromString($input->getArgument('tournamentId'));

        $participants[] = new Participant($cardId);
        if ($optionalCardId) {
            $participants[] = new Participant($optionalCardId);
        }
        $command = new RegisterSubmissionOnTournament(Uuid::uuid4(), $tournamentId, $participants);
        $repository = new TournamentSubmissionRepository(new Redis(), new EventDispatcher());
        $handler = new RegisterSubmissionOnTournamentCommandHandler($repository);
        $handler($command);

        return 0;
    }
}
