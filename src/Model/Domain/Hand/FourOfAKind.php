<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\Hand;

class FourOfAKind
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFourOfAKind(array $cards): bool
    {
        $ranksCards = Hand::getRanksWithTheirCards($cards);

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) === 4) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Card[] $cards
     */
    public static function getFourOfAKindRank(array $cards): ?CardRank
    {
        $ranksCards = Hand::getRanksWithTheirCards($cards);

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) === 4) {
                return $rankCards[array_key_first($rankCards)]->getRank();
            }
        }

        return null;
    }

    /**
     * @param Card[] $cards
     * @return Card[]
     */
    public static function getLeftOverCards(array $cards): array
    {
        $ranksCards = Hand::getRanksWithTheirCards($cards);

        $result = [];

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) !== 4) {
                $result = array_merge($result, $rankCards);
            }
        }

        return $result;
    }
}
