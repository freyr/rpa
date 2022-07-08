<?php

namespace Freyr\RPA\Voting\Infrastructure;

use Freyr\RPA\Voting\ReadModel\OpenVotingReadModel;
use Freyr\RPA\Voting\ReadModel\OpenVotingReadModelRepository;

class OpenVotingRedisReadModelRepository implements OpenVotingReadModelRepository
{

    public function getAllOpenVoting(): OpenVotingReadModel
    {
        return new OpenVotingReadModel();
    }
}
