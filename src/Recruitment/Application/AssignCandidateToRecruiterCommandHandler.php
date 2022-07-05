<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\Application;

use Freyr\RPA\Recruitment\DomainModel\Command\AssignCandidateToRecruiterCommand;
use Freyr\RPA\Recruitment\DomainModel\RecruiterRepository;
use Freyr\RPA\Recruitment\DomainModel\RecruitmentProcessDomainService;

class AssignCandidateToRecruiterCommandHandler
{
    public function __construct(private RecruiterRepository $repository)
    {
    }

    public function __invoke(AssignCandidateToRecruiterCommand $command)
    {
        $recruiters = $this->repository->getAll();
        $service = new RecruitmentProcessDomainService();
        foreach ($recruiters as $recruiter) {
            $service->addRecruiter($recruiter);
        }

        $recruiter = $service->select($command);
        $recruiter->assign($command);
        $this->repository->persist($recruiter);
    }
}
