<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;

class FullHouse
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFullHouse(array $cards): bool
    {
        $ranks = [
            CardRank::ACE->value => [],
            CardRank::KING->value => [],
            CardRank::QUEEN->value => [],
            CardRank::JACK->value => [],
            CardRank::TEN->value => [],
            CardRank::NINE->value => [],
            CardRank::EIGHT->value => [],
            CardRank::SEVEN->value => [],
            CardRank::SIX->value => [],
            CardRank::FIVE->value => [],
            CardRank::FOUR->value => [],
            CardRank::THREE->value => [],
            CardRank::TWO->value => [],
        ];

        foreach ($cards as $card) {
            $ranks[$card->getRank()->value][] = $card;
        }

        $threeCards = false;
        $pair = false;

        /** @var Card[] $rankCards */
        foreach ($ranks as $rankCards) {
            if (count($rankCards) === 3) {
                $threeCards = true;
            }

            if (count($rankCards) === 2) {
                $pair = true;
            }
        }

        if ($threeCards && $pair) {
            return true;
        }

        return false;
    }
}
