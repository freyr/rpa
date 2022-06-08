<?php

declare(strict_types=1);

namespace Freyr\RPA\Cli;

use Exception;
use Freyr\RPA\Matchmaking\DomainModel\Commands\CreateTournament;
use Freyr\RPA\Matchmaking\Application\CreateTournamentCommandHandler;
use Freyr\RPA\Matchmaking\Infrastructure\TournamentSubmissionRepository;
use Ramsey\Uuid\Uuid;
use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CreateNewTournament extends Command
{

    protected function configure(): void
    {
        $this->setName('tournament:create');
        $this->addArgument('name', InputArgument::REQUIRED, 'Tournament name');
    }

    /**
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $uuid = Uuid::uuid4();
        $command = new CreateTournament($uuid, $input->getArgument('name'));
        $repository = new TournamentSubmissionRepository(new Redis(), new EventDispatcher());
        $handler = new CreateTournamentCommandHandler($repository);
        $handler($command);

        $table = new Table($output);
        $table
            ->setHeaders(['uuid', 'name'])
            ->setRows([
                [$uuid->toString(), $input->getArgument('name')],
            ])
        ;
        $table->render();
        return 0;
    }
}
