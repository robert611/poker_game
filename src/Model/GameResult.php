<?php

declare(strict_types=1);

namespace App\Model;

class GameResult
{
    /**
     * @var UserResult[]
     */
    private array $userResults;

    /**
     * @return UserResult[]
     */
    public function getUserResults(): array
    {
        return $this->userResults;
    }

    /**
     * @var UserResult[] $userResults
     */
    public static function create(array $userResults): self
    {
        $gameResult = new self();
        $gameResult->userResults = $userResults;

        return $gameResult;
    }
}
