<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

class Recruiter
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

    public function assign()
    {
        return new CVWasAssignedToRecuiter();
    }
}
