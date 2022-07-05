<?php

namespace Freyr\RPA\Recruitment\Infrastructure;

use Freyr\RPA\Recruitment\ReadModel\DefaultViewReadModelRepository;
use Freyr\RPA\Recruitment\ReadModel\Query;

class DefaultViewDbReadModelRepository implements DefaultViewReadModelRepository
{

    public function find(Query\DefaultViewQuery $query): array
    {
        ///sql
        return [];
    }
}
