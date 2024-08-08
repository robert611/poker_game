<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Domain\Card;
use App\Model\Domain\Hand;

class UserCards
{
    private int $userId;
    /** @var Card[] $cards */
    private array $cards = [];
    private Hand $hand;

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

    /**
     * @param Card[] $cards
     */
    public static function create(int $userId, array $cards, Hand $hand): self
    {
        $userHand = new self();
        $userHand->userId = $userId;
        $userHand->cards = $cards;
        $userHand->hand = $hand;

        return $userHand;
    }

    /**
     * @param UserCards[] $usersCards
     */
    public static function hasRepeatedHand(array $usersCards): bool
    {
        $handsStrength = [];

        foreach ($usersCards as $userCards) {
            $handsStrength[] = $userCards->getHand()->value;
        }

        if (count(array_unique($handsStrength)) === count($handsStrength)) {
            return false;
        }

        return true;
    }
}
