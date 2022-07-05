<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

use Freyr\RPA\Recruitment\DomainModel\Command\AssignCandidateToRecruiterCommand;
use Freyr\RPA\Shared\AggregateChanged;
use Freyr\RPA\Shared\AggregateRoot;

class Recruiter extends AggregateRoot
{

    private int $numberOfAssignedCVs;
    private bool $isOnHoliday;
    private bool $isEmployed;
    private array $preferredCategories = [];
    private array $forbiddenCategories = [];

    public function isAvailable(string $category): bool
    {
        if ($this->numberOfAssignedCVs < 5 && $this->isActive()) {
            if (!in_array($category, $this->forbiddenCategories)) {
                return true;
            }
        }

        return false;
    }

    private function isActive(): bool
    {
        return !$this->isOnHoliday && $this->isEmployed;
    }

    public function assign(AssignCandidateToRecruiterCommand $command): void
    {
        $this->recordThat(new CandidateWasAssignedToRecuiter());
    }
}
