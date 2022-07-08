<?php

namespace Freyr\RPA\Voting\DomainModel;

use Ramsey\Uuid\UuidInterface;

class CastVoteCommand
{

    private UuidInterface $aggregateUuid;
    private UuidInterface $voterId;
    private bool $vote;

    public function __construct(UuidInterface $aggregateId, UuidInterface $voterId, bool $vote)
    {
        $this->aggregateUuid = $aggregateId;
        $this->voterId = $voterId;
        $this->vote = $vote;
    }

    public function getAggregateUuid(): UuidInterface
    {
        return $this->aggregateUuid;
    }

    /**
     * @return UuidInterface
     */
    public function getVoterId(): UuidInterface
    {
        return $this->voterId;
    }

    /**
     * @return bool
     */
    public function isVote(): bool
    {
        return $this->vote;
    }



}
