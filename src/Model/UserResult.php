<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Domain\Card;
use App\Model\Domain\Hand;

class UserResult
{
    private int $userId;
    private int $place;
    private Hand $hand;
    /** @var Card[] $cards  */
    private array $cards = [];

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getHand(): Hand
    {
        return $this->hand;
    }

    public function getPlace(): int
    {
        return $this->place;
    }

    /**
     * @param Card[] $cards
     */
    public static function create(int $userId, array $cards, int $place, Hand $hand): self
    {
        $userResult = new self();
        $userResult->userId = $userId;
        $userResult->place = $place;
        $userResult->hand = $hand;
        $userResult->cards = $cards;

        return $userResult;
    }
}
