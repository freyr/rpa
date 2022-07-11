<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

use Freyr\RPA\Recruitment\DomainModel\Command\AssignCandidateToRecruiterCommand;
use Freyr\RPA\Shared\AggregateRoot;

/**
 * Domain service is used cause this behaviour cannot be put inside of Recruitment Aggregate
 * nor in the Candidate Aggregate. Additionally, process could be modelled as stateless function
 */
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
