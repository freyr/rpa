<?php

namespace Freyr\RPA\Recruitment\ReadModel;

interface DefaultViewReadModelRepository
{

    public function find(Query\DefaultViewQuery $query);
}
