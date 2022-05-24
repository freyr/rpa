<?php

namespace Freyr\RPA\Models;

use Redis;

class JobRepository
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis-rpa');
    }

    public function store(Job $job): void
    {
        $this->redis->set($job->getId(), json_encode($job));
    }


    public function getById(string $jobId): job
    {
        return Job::fromJson($this->redis->get($jobId));
    }
}
