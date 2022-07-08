<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\Application;

use Freyr\RPA\Voting\ReadModel\OpenVotingQuery;
use Freyr\RPA\Voting\ReadModel\OpenVotingReadModel;
use Freyr\RPA\Voting\ReadModel\OpenVotingReadModelRepository;

class GetOpenVotingQueryHandler
{
    public function __construct(private OpenVotingReadModelRepository $openVotingReadModelRepository)
    {
    }

    public function __invoke(OpenVotingQuery $query): OpenVotingReadModel
    {
        return $this->openVotingReadModelRepository->getAllOpenVoting();
    }
}
