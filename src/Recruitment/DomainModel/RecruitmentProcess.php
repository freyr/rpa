<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

use Freyr\RPA\Recruitment\DomainModel\Command\AssignCVToRecruiterCommand;
use Freyr\RPA\Recruitment\DomainModel\Event\AggregateEvent;

class RecruitmentProcess
{
    /** @var Recruiter[] */
    private array $recruiters = [];
    private array $candidates = [];

    public function assign(AssignCVToRecruiterCommand $command): AggregateEvent
    {

        // wagi w oparciu o preferowane kategorie + najmniejsza ilosc aktywnych CV
        $availableRecruiters = [];
        foreach ($this->recruiters as $recruiter) {
            if ($recruiter->isAvailable($command->getCategory())) {
                $availableRecruiters[] = $recruiter;
            }
        }

        if (count($availableRecruiters) > 0) {
            foreach ($availableRecruiters as $availableRecruiter) {
                $availableRecruiter->preffere($command->getCategory());
            }
        }
        /**  @var Recruiter */
        if ($availableRecruiter) {
            return $availableRecruiter->assign();
        } else {
            return $this->waitingQueue->puhs();

        }

    }
}
