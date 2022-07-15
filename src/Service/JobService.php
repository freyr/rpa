<?php

namespace Freyr\RPA\Service;

use Freyr\RPA\Models\Status;
use Freyr\RPA\Repository\JobRepository;

class JobService
{
    public function __construct(private JobRepository $repository)
    {
    }

    public function createJob($type): int
    {
        return $this->repository->createJob($type, 1, Status::READY_FOR_EXECUTION);
    }

    public function scheduleJob(int $jobId): void
    {
        $this->repository->updateStatusJob($jobId, Status::SCHEDULED);
    }

    public function executeJob(int $jobId): void
    {
        $this->repository->updateStatusJob($jobId, Status::SENT_TO_RUNNER);
    }

    public function finalizeJob(int $jobId, string $report)
    {
        if ($report === 'success') {
            $this->repository->updateStatusJob($jobId, Status::FINISH_WITH_SUCCESS);
        } else {
            $runNumber = $this->repository->getJobRunNumber($jobId);
            if ($runNumber < 2) {
                $this->repository->rerunJob($jobId, $runNumber + 1);
            } else {
                $this->repository->updateStatusJob($jobId, Status::FINISH_WITH_FAILURE);
            }
        }
    }

    public function getRunNumber(int $jobId): int
    {
        return $this->repository->getJobRunNumber($jobId);
    }
}
