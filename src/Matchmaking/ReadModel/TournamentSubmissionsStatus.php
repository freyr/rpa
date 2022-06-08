<?php

declare(strict_types=1);

namespace Freyr\RPA\Matchmaking\ReadModel;

class TournamentSubmissionsStatus
{
    private array $submissions;

    public function __construct(private string $tournamentName)
    {
    }

    public function add(SubmissionStatus $status)
    {
        $this->submissions[] = $status;
    }

    public function asArray()
    {
        return [
            'name' => $this->tournamentName,
            'submissions' => $this->submissions
        ];
    }
}
