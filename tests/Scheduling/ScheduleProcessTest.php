<?php

namespace Tests\Scheduling;

use Freyr\RPA\Schedule\DomainModel\Job;
use Freyr\RPA\Schedule\Infrastructure\JobRepository;
use PHPUnit\Framework\TestCase;

class ScheduleProcessTest extends TestCase
{
    /**
     * @test
     */
    public function shouldScheduleProcess2Times(): void
    {
        $job = Job::orderNewJob('screen');
        $job->schedule();
        $job->execute();
        $job->finalize('error');
        $job->execute();
        $job->finalize('success');

        $repository = new JobRepository();
        $repository->store($job);

        $job2 = $repository->load($job->aggregateId());
        $jobRef = new \ReflectionObject($job2);
        $runNumberProperty = $jobRef->getProperty('runNumber');
        $runNumberProperty->setAccessible(true);

        $actualRunNumber = $runNumberProperty->getValue($job2);
        self::assertEquals(2, $actualRunNumber);
    }
}
