<?php

namespace Freyr\RPA\Models;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class JobsRepository
{
    /**
     * @param int $processId
     * @param int $groupId
     * @param int $environmentId
     * @param int $destinationId
     * @param $userId
     * @return Job[]|JsonSerializable
     */
    public function createJobs(int $processId, int $groupId, int $environmentId, int $destinationId, $userId): array|JsonSerializable
    {
        # find jobs templates with matching criteria
        $jobsTemplates = $this->findJobsTemplates($processId, $groupId, $environmentId, $userId);

        # persist templates as jobs to execute
        /** @var Job[] $jobs */
        $jobs = [];
        foreach ($jobsTemplates as $t)
        {
            $jobs[] = new Job(
                $t['id'],
                $t['name'],
                $t['user_id'],
                $t['definition'],
                $t['parameters'],
                $environmentId,
                $destinationId,
                Status::READY_FOR_EXECUTION
            );
        }

        # Persist newly created jobs to be handled later by executor

        # return jobs to be viewed on UI
        return $jobs;
    }

    #[ArrayShape([
        'id' => "int",
        'name' => "string",
        'user_id' => "int",
        'definition' => "string",
        'parameters' => "string",
    ])]
    private function findJobsTemplates(int $processId, int $groupId, int $environmentId, $userId): array
    {
        return [];
    }

}
