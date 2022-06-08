<?php

namespace Freyr\RPA\Matchmaking\ReadModel;

interface TournamentReadModelRepository
{
    public function find(): array;

    public function findAll();

    public function findWithOpenRegistration();
}
