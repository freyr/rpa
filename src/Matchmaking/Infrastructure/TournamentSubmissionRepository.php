<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\Infrastructure;

use Freyr\RPA\Matchmaking\DomainModel\TournamentSubmissions;
use Ramsey\Uuid\UuidInterface;
use Redis;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TournamentSubmissionRepository
{
    private Redis $redis;
    private EventDispatcher $dispatcher;

    public function __construct(Redis $redis, EventDispatcher $dispatcher)
    {
        $this->redis = $redis;
        $this->redis->connect('redis-rpa');
        $this->dispatcher = $dispatcher;
    }

    public function load(UuidInterface $tournamentId)
    {
        $data = $this->redis->get($tournamentId->toString());
        return TournamentSubmissions::fromArray(json_decode($data, true));
    }

    public function store(TournamentSubmissions $tournamentSubmissions)
    {
        $this->redis->set($tournamentSubmissions->getUuid()->toString(), json_encode($tournamentSubmissions));

        $eventExtractor = fn(): array => $this->collectEvents();
        $events = $eventExtractor->call($tournamentSubmissions);

        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }

    // this is a side effect from command flow that updates a projection for list of created tournaments
    // every time when tournament is created or removed, this redis list is updated
    public function addToTournamentListProjection(TournamentSubmissions $tournament)
    {
        $data = $tournament->jsonSerialize();
        $payload = [
            'uuid' => $data['uuid'],
            'name' => $data['name']
        ];
        $this->redis->lPush('tournaments', json_encode($payload));
    }
}
