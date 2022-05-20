<?php

namespace Freyr\RPA\UI;

use Freyr\RPA\Models\JobsRepository;

class SchedulingController
{
    public function __construct(private JobsRepository $repository)
    {

    }

    public function scheduleProcess(): string
    {
        $userId = 1;
        $processTemplate = 10;
        $groupId = 343;
        $environmentId = 763;
        $destinationId = 2;

        $jobs = $this->repository->createJobs($processTemplate, $groupId, $environmentId, $destinationId, $userId);

        return json_decode($jobs);
    }

    public function resultCallback(int $jobId, bool $status): string
    {

        return 'accepted';
    }
}
