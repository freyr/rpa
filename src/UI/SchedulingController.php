<?php

namespace Freyr\RPA\UI;

use Freyr\RPA\Models\JobsRepository;

class SchedulingController
{
    public function __construct(private JobsRepository $repository)
    {

    }

    public function scheduleProcess(int $userId, int $processId, int $groupId, int $environmentId, int $destinationId): string
    {
        $jobs = $this->repository->createJobs($processId, $groupId, $environmentId, $destinationId, $userId);

        return json_encode($jobs);
    }

    public function resultCallback(int $jobId, bool $status): string
    {
        $this->repository->finishJob($jobId, $status);
        return 'accepted';
    }
}
