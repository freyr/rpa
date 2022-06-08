<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\Application;


use Freyr\RPA\Matchmaking\ReadModel\ListOfTournaments;
use Freyr\RPA\Matchmaking\ReadModel\Queries\TournamentsQuery;
use Freyr\RPA\Matchmaking\ReadModel\TournamentReadModelRepository;
use Ramsey\Uuid\Uuid;

class ListTournamentQueryHandler
{

    public function __construct(private TournamentReadModelRepository $repository)
    {
    }

    public function __invoke(TournamentsQuery $query): ListOfTournaments
    {
        if ($query->getStatus() === 'registration-in-progress') {
            $data = $this->repository->findWithOpenRegistration();
        } else {
            $data = $this->repository->findAll();
        }


        $tournaments = new ListOfTournaments();
        foreach ($data as $row) {
            if (!$row) {
                continue;
            }
            $tournaments->add(Uuid::fromString($row['uuid']), $row['name']);
        }

        return $tournaments;
    }
}
