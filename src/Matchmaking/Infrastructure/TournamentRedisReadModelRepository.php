<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\Infrastructure;

use Freyr\RPA\Matchmaking\ReadModel\TournamentReadModelRepository;
use Redis;

class TournamentRedisReadModelRepository implements TournamentReadModelRepository
{

    public function __construct(private Redis $redis)
    {
        $this->redis->connect('redis-rpa');
    }

    public function find(): array
    {
        $payload = $this->redis->lRange('tournaments', 0, 10);
        $data = [];
        foreach ($payload as $row) {
            $data[] = json_decode($row, true);
        }
        return $data;
    }

    public function findAll(): array
    {
        return $this->find();
    }

    public function findWithOpenRegistration(): array
    {
        return $this->find();
    }


}
