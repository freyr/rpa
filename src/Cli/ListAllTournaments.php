<?php

declare(strict_types=1);

namespace Freyr\RPA\Cli;

use Carbon\Carbon;
use Exception;
use Freyr\RPA\Matchmaking\Infrastructure\TournamentRedisReadModelRepository;
use Freyr\RPA\Matchmaking\Application\ListTournamentQueryHandler;
use Freyr\RPA\Matchmaking\ReadModel\Queries\TournamentsQuery;
use Redis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAllTournaments extends Command
{

    protected function configure(): void
    {
        $this->setName('tournament:list');
    }

    /**
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $query = new TournamentsQuery('registration-in-progress');
        $repository = new TournamentRedisReadModelRepository(new Redis());
        $handler = new ListTournamentQueryHandler($repository);
        $tournaments = $handler($query);

        $table = new Table($output);
        $table
            ->setHeaders(['uuid', 'name'])
            ->setRows(iterator_to_array($tournaments));
        $table->render();
        return 0;
    }
}
