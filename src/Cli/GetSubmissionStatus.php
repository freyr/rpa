<?php

declare(strict_types=1);

namespace Freyr\RPA\Cli;

use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetSubmissionStatus extends Command
{

    protected function configure(): void
    {
        $this->setName('submission:status');
        $this->addArgument('tournamentId', InputArgument::REQUIRED, 'Id of an tournament (uuid) call tournament:create and tournament:list to get one');
    }

    /**
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $tournamentId = Uuid::fromString($input->getArgument('tournamentId'));


//        $table = new Table($output);
//        $table
//            ->setHeaders(['uuid', 'name'])
//            ->setRows(iterator_to_array($tournaments));
//        $table->render();
        return 0;
    }
}
