<?php

namespace Freyr\RPA\Repository;

use Doctrine\DBAL\Connection;
use Freyr\RPA\Models\Status;

class JobRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function createJob(string $type, int $runNumber, string $status): int
    {
        $sql = 'INSERT INTO jobs (type, run_number, status) values (:type, :run_number, :status)';
        $this->db->executeQuery($sql, ['type' => $type, 'run_number' => $runNumber, 'status' => $status]);
        return $this->db->lastInsertId();
    }

    public function updateStatusJob(int $jobId, string $status): void
    {
        $sql = 'UPDATE jobs set status = :status WHERE id = :id';
        $this->db->executeQuery($sql, ['status' => $status, 'id' => $jobId]);
    }

    public function rerunJob(int $jobId, $runNumber)
    {
        $sql = 'UPDATE jobs set status = :status, run_number = :run_number WHERE id = :id';
        $this->db->executeQuery($sql, ['status' => Status::SCHEDULED, 'run_number' => $runNumber, 'id' => $jobId]);
    }

    public function getJobRunNumber(int $jobId): int
    {
        $sql = 'SELECT run_number FROM jobs WHERE id = :id';
        return (int) $this->db->fetchOne($sql, ['id' => $jobId]);
    }
}
