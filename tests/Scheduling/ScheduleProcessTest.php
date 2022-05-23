<?php

namespace Tests\Scheduling;

use Freyr\RPA\Models\JobsRepository;
use Freyr\RPA\UI\SchedulingController;
use PHPUnit\Framework\TestCase;

class ScheduleProcessTest extends TestCase
{
    /**
     * @test
     */
    public function shouldScheduleProcess()
    {
        $repository = new JobsRepository();
        $controller = new SchedulingController($repository);
        $jobs = $controller->scheduleProcess(1,2,3,4,5,);
        self::assertEquals(5, count(json_decode($jobs)));
    }
}
