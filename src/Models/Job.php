<?php

namespace Freyr\RPA\Models;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;
use Ramsey\Uuid\Uuid;

class Job implements JsonSerializable
{
    public function __construct(
        private string $id,
        private string $type,
        private string $status,
        private int $runNumber,
    )
    {
    }

    public static function create(string $type): Job
    {
        return new self(
            Uuid::uuid4()->toString(),
            $type,
            Status::READY_FOR_EXECUTION,
            1
        );
    }

    public static function fromJson(string $json): Job
    {
        $data = json_decode($json, true);
        return new self(
            $data['id'],
            $data['type'],
            $data['status'],
            $data['run_number']
        );
    }

    public function schedule(): void
    {
        if ($this->status === Status::READY_FOR_EXECUTION)
        {
            $this->status = Status::SCHEDULED;
        }
    }

    public function execute(): void
    {
        if ($this->status === Status::SCHEDULED)
        {
            $this->status = Status::SENT_TO_RUNNER;
        }
    }

    public function finalize(string $report): void
    {
        if ($this->status === Status::SENT_TO_RUNNER)
        {
            if ($report === 'success') {
                $this->status = Status::FINISH_WITH_SUCCESS;
            } else {
                if ($this->runNumber < 2) {
                    $this->status = Status::SCHEDULED;
                    $this->runNumber++;
                } else {
                    $this->status = Status::FINISH_WITH_FAILURE;
                }
            }
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    #[ArrayShape([
        'id' => 'int',
        'type' => 'string',
        'status' => 'string',
        'run_number' => 'int'
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
            'run_number' => $this->runNumber
        ];
    }
}
