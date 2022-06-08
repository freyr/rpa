<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\Infrastructure;

use Freyr\RPA\Matchmaking\DomainModel\Events\SubmissionWasCompleted;
use Redis;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SubmissionStatusProjectionListener implements EventSubscriberInterface
{
    public function __construct(private Redis $redis)
    {
        $this->redis->connect('redis-rpa');
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SubmissionWasCompleted::name() => 'onCompletedSubmission',
        ];
    }

    public function onCompletedSubmission(SubmissionWasCompleted $event): void
    {
        $status = [
            'status' => 'completed',
            'memberships' => $event->getMembershipCardsIds()
        ];

        $this->redis->lPush('tournament:' . $event->getId(), json_encode($status));
    }

}
