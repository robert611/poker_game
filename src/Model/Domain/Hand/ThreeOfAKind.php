<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\Hand;

class ThreeOfAKind
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedThreeOfAKind(array $cards): bool
    {
        $ranksCards = Hand::getRanksWithTheirCards($cards);

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) === 3) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Card[] $cards
     */
    public static function getThreeOfAKindCardsRank(array $cards): ?CardRank
    {
        $ranksCards = Hand::getRanksWithTheirCards($cards);

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) === 3) {
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

        $leftOverCards = [];

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) !== 3) {
                $leftOverCards = array_merge($leftOverCards, $rankCards);
            }
        }

        $result = [];

        // Keep the original cards order in result array
        foreach ($cards as $card) {
            foreach ($leftOverCards as $leftOverCard) {
                if ($card === $leftOverCard) {
                    $result[] = $leftOverCard;
                }
            }
        }

        return $result;
    }
}
