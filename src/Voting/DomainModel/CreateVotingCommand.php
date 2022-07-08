<?php

declare(strict_types=1);

namespace Freyr\RPA\Voting\DomainModel;

use Ramsey\Uuid\UuidInterface;

class CreateVotingCommand
{
    private string $name;
    private WinningStrategy $winningStrategy;
    private int $quorum;
    private UuidInterface $uuid;

    public function __construct(UuidInterface $uuid, string $name, WinningStrategy $winningStrategy, int $quorum)
    {
        if (strlen($name) > 200) {
            throw new \Exception('Name is too long');
        }

        $this->uuid = $uuid;
        $this->name = $name;
        $this->winningStrategy = $winningStrategy;
        $this->quorum = $quorum;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return WinningStrategy
     */
    public function getWinningStrategy(): WinningStrategy
    {
        return $this->winningStrategy;
    }

    /**
     * @return int
     */
    public function getQuorum(): int
    {
        return $this->quorum;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getTimeLimit(): int
    {
        return 15;
    }


}
