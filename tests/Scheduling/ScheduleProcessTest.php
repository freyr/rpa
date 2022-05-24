<?php

namespace Tests\Scheduling;

use Freyr\RPA\Models\Job;
use Freyr\RPA\Models\JobRepository;
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

        $repository = new JobRepository();
        $repository->store($job);

        $job2 = $repository->getById($job->getId());
        $jobRef = new \ReflectionObject($job2);
        $runNumberProperty = $jobRef->getProperty('runNumber');
        $runNumberProperty->setAccessible(true);

        $actualRunNumber = $runNumberProperty->getValue($job2);
        self::assertEquals(2, $actualRunNumber);
    }
}
