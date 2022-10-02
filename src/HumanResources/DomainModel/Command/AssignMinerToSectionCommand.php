<?php

declare(strict_types=1);

namespace Freyr\RPA\HumanResources\DomainModel\Command;

class AssignMinerToSectionCommand
{

    public function __construct(private string $minerId, private string $sectionId)
    {
    }

    public function getMinerId(): string
    {
        return $this->minerId;
    }

    public function getSectionId(): string
    {
        return $this->sectionId;
    }



}
