<?php

namespace Freyr\RPA\Voting\ReadModel;

interface OpenVotingReadModelRepository
{

    public function getAllOpenVoting(): OpenVotingReadModel;
}
