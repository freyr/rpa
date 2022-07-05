<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\Application;

use Freyr\RPA\Recruitment\ReadModel\DefaultView;
use Freyr\RPA\Recruitment\ReadModel\DefaultViewReadModelRepository;
use Freyr\RPA\Recruitment\ReadModel\Query\DefaultViewQuery;
use JsonSerializable;

class GetDefaultViewQueryHandler
{
    public function __construct(private DefaultViewReadModelRepository $repository)
    {
    }

    public function __invoke(DefaultViewQuery $query): JsonSerializable
    {
        $data = $this->repository->find($query);
        $defaultView = new DefaultView();
        foreach ($data as $row) {
            $defaultView->add($row);
        }

        return $defaultView;
    }
}
