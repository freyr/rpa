<?php

namespace Tests\Scheduling;

use Freyr\RPA\Models\Job;
use Freyr\RPA\Repository\DbFactory;
use Freyr\RPA\Repository\JobRepository;
use Freyr\RPA\Service\JobService;
use PHPUnit\Framework\TestCase;

class ScheduleProcessTest extends TestCase
{
    /**
     * @test
     */
    public function shouldScheduleProcess()
    {
        $job = Job::create('screen');
        $job->schedule();
        $job->execute();
        $job->finalize('error');
        $job->execute();
        $job->finalize('success');

        $repository = new JobRepository(DbFactory::create());
        $service = new JobService($repository);
        $jobId = $service->createJob('screen');

        $service->scheduleJob($jobId);
        $service->executeJob($jobId);
        $service->finalizeJob($jobId, 'error');
        $service->executeJob($jobId);
        $service->finalizeJob($jobId, 'success');
        $runNumber = $service->getRunNumber($jobId);

        self::assertEquals(2, $runNumber);
    }
}
