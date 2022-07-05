<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

use Freyr\RPA\Recruitment\DomainModel\Command\AssignCandidateToRecruiterCommand;
use Freyr\RPA\Recruitment\DomainModel\Event\AggregateEvent;
use Freyr\RPA\Shared\AggregateRoot;

class RecruitmentProcessDomainService extends AggregateRoot
{
    /** @var Recruiter[] */
    private array $recruiters = [];

    public function addRecruiter(Recruiter $recruiter)
    {
        $this->recruiters[] = $recruiter;
    }

    public function select(AssignCandidateToRecruiterCommand $command): Recruiter
    {
        // calculate which recruiters can handle this candidate based on
        // +offer details
        // +candidate tags
        // +numbers of open recruitment particular recruiters are already involved in
        // selected recruiter will be returned
        return reset($this->recruiters);
    }
}
