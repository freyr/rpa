<?php

declare(strict_types=1);

namespace Freyr\RPA\Recruitment\DomainModel;

use Freyr\RPA\Recruitment\DomainModel\Command\RegisterCVCommand;
use Freyr\RPA\Recruitment\DomainModel\Event\AggregateEvent;
use Freyr\RPA\Recruitment\DomainModel\Event\CVWasUpdated;
use Freyr\RPA\Recruitment\DomainModel\Event\NewCVWasCreated;
use Ramsey\Uuid\UuidInterface;

class Candidate
{
    public function __construct(private UuidInterface $uuid)
    {
    }

    /** @var array|CV[]  */
    private array $cv = [];
    public function registerCV(RegisterCVCommand $command): AggregateEvent
    {
        $pesel = (string) $command->getPesel();

        $category = null;
        if ($command->getOffer()) {
            $category = $command->getOffer()->getCategory();
        }

        $cv = new CV($category);
        $this->cv[] = $cv;
        return new NewCVWasCreated();

    }

    public function assignRecruiter(RecruiterId $recruiter)
    {

    }
}
