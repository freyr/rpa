<?php

namespace Freyr\RPA\Schedule\DomainModel;

class Status
{
    public const READY_FOR_EXECUTION = 'ready';
    public const SCHEDULED = 'scheduled';
    public const SENT_TO_RUNNER = 'sent_to_runner';
    public const FINISH_WITH_SUCCESS = 'succeeded';
    public const FINISH_WITH_FAILURE = 'failed';
}
