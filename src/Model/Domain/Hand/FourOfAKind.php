<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;

class FourOfAKind
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFourOfAKind(array $cards): bool
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

        /** @var Card[] $rankCards */
        foreach ($ranks as $rankCards) {
            if (count($rankCards) === 4) {
                return true;
            }
        }

        return false;
    }
}
