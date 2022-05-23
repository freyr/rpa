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
                $t['type'],
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


    public function finishJob(int $jobId, bool $status)
    {
        // update status for a jobId
    }


    #[ArrayShape([
        'id' => "int",
        'name' => "string",
        'type' => 'string',
        'user_id' => "int",
        'definition' => "string",
        'parameters' => "string",
    ])]
    private function findJobsTemplates(int $processId, int $groupId, int $environmentId, $userId): array
    {
        return [
            ['id' => 1, 'name' => 'Test Job 1', 'type' => 'test', 'user_id' => 3, 'definition' => 'alfa|cobra|4', 'parameters' => '1|2|3|cde'],
            ['id' => 3, 'name' => 'Test Job 4', 'type' => 'test', 'user_id' => 3, 'definition' => 'is_a|cdn|login|45', 'parameters' => '1|2|3|cde'],
            ['id' => 20, 'name' => 'Test Job 83', 'type' => 'test', 'user_id' => 3, 'definition' => 'beta|cobra|4|gca5', 'parameters' => '1|2|3|cde'],
            ['id' => 13, 'name' => 'Test Job 34a', 'type' => 'screen', 'user_id' => 2, 'definition' => '', 'parameters' => '1|2|3|cde'],
            ['id' => 3, 'name' => 'Test Job 12', 'type' => 'test', 'user_id' => 2, 'definition' => 'alfa|4', 'parameters' => '1|2|3|cde'],
        ];
    }
}
