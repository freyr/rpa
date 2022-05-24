<?php

namespace Freyr\RPA\Schedule\DomainModel;

use Freyr\RPA\Schedule\DomainModel\Events\JobWasFinishedWithFailure;
use Freyr\RPA\Schedule\DomainModel\Events\JobWasFinishedWithSuccess;
use Freyr\RPA\Schedule\DomainModel\Events\JobWasReScheduled;
use Freyr\RPA\Schedule\DomainModel\Events\JobWasScheduled;
use Freyr\RPA\Schedule\DomainModel\Events\JobWasSentToRunner;
use Freyr\RPA\Schedule\DomainModel\Events\NewJobWasOrdered;
use Freyr\RPA\Shared\AggregateChanged;
use Freyr\RPA\Shared\AggregateRoot;
use Ramsey\Uuid\Uuid;

class Job extends AggregateRoot
{
    private string $id;
    private string $type;
    private string $status;
    private int $runNumber;

    public static function orderNewJob(
        string $type
    ): Job {
        $job = new self();
        $job->id = Uuid::uuid4();
        $job->recordThat(
            NewJobWasOrdered::occur(
                $job->aggregateId(),
                [
                    'type' => $type,
                    'run_number' => 1,
                    'status' => Status::READY_FOR_EXECUTION
                ]
            )
        );

        return $job;
    }

    public function aggregateId(): string
    {
        return $this->id;
    }

    public function schedule(): void
    {
        if ($this->status === Status::READY_FOR_EXECUTION)
        {
            $this->recordThat(JobWasScheduled::occur($this->id));
        }
    }

    public function execute(): void
    {
        if ($this->status === Status::SCHEDULED)
        {
            $this->recordThat(JobWasSentToRunner::occur($this->id));
        }
    }

    public function finalize(string $report): void
    {
        if ($this->status === Status::SENT_TO_RUNNER)
        {
            if ($report === 'success') {
                $this->recordThat(JobWasFinishedWithSuccess::occur($this->id));
            } else {
                if ($this->runNumber < 2) {
                    $this->recordThat(JobWasReScheduled::occur($this->id, ['run_number' => $this->runNumber + 1]));
                } else {
                    $this->recordThat(JobWasFinishedWithFailure::occur($this->id));
                }
            }
        }
    }

    protected function apply(AggregateChanged $event): void
    {
        $class = get_class($event);
        $handler = match ($class) {
            NewJobWasOrdered::class => function (NewJobWasOrdered $event) {$this->whenNewJobWasOrdered($event);},
            JobWasSentToRunner::class => function (JobWasSentToRunner $event) {$this->whenJobWasSentToRunner($event);},
            JobWasScheduled::class => function (JobWasScheduled $event) {$this->whenJobWasScheduled($event);},
            JobWasFinishedWithSuccess::class => function (JobWasFinishedWithSuccess $event) {$this->whenJobWasFinishedWithSuccess($event);},
            JobWasFinishedWithFailure::class => function (JobWasFinishedWithFailure $event) {$this->whenJobWasFinishedWithFailure($event);},
            JobWasReScheduled::class => function (JobWasReScheduled $event) {$this->whenJobWasReScheduled($event);}
        };

        $handler($event);
    }

    private function whenNewJobWasOrdered(NewJobWasOrdered $event)
    {
        $this->id = $event->field('_uuid');
        $this->runNumber = $event->field('run_number');
        $this->status = $event->field('status');
    }

    private function whenJobWasScheduled(JobWasScheduled $event)
    {
        $this->status = Status::SCHEDULED;
    }

    private function whenJobWasSentToRunner(JobWasSentToRunner $event)
    {
        $this->status = Status::SENT_TO_RUNNER;
    }

    private function whenJobWasFinishedWithSuccess(JobWasFinishedWithSuccess $event)
    {
        $this->status = Status::FINISH_WITH_SUCCESS;
    }

    private function whenJobWasReScheduled(JobWasReScheduled $event)
    {
        $this->status = Status::SCHEDULED;
        $this->runNumber = $event->field('run_number');
    }

    private function whenJobWasFinishedWithFailure(JobWasFinishedWithFailure $event)
    {
        $this->status = Status::FINISH_WITH_FAILURE;
    }

}
