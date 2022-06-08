<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\DomainModel\Events;

use Freyr\RPA\Matchmaking\DomainModel\Submission;

class SubmissionFailedToComplete
{

    /**
     * @param Submission $submission
     */
    public function __construct(Submission $submission)
    {
    }
}
