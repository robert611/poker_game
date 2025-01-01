<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\Hand;

class FullHouse
{
    /**
     * @param Card[] $cards
     * @return array{threeCards: Card[], pair: Card[]}
     */
    public static function getFullHouseCards(array $cards): array
    {
        $ranksCards = Hand::getRanksWithTheirCards($cards);

        $threeCards = [];
        $pair = [];

        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) === 3) {
                $threeCards = $rankCards;
            }

            if (count($rankCards) === 2) {
                if (count($pair) > 0) {
                    if ($rankCards[0]->getRank()->getStrength() > $pair[0]->getRank()->getStrength()) {
                        $pair = $rankCards;
                    }
                    continue;
                }

                $pair = $rankCards;
            }
        }

        return ['threeCards' => $threeCards, 'pair' => $pair];
    }

    /**
     * @param Card[] $cards
     * @return array{threeCardsRank: ?CardRank, pairRank: ?CardRank}
     */
    public static function getFullHouseCardsRanks(array $cards): array
    {
        $fullHouseCards = self::getFullHouseCards($cards);

        $threeCards = $fullHouseCards['threeCards'];
        $pair = $fullHouseCards['pair'];

        $threeCardsRank = isset($threeCards[0]) ? $threeCards[0]->getRank() : null;
        $pairRank = isset($pair[0]) ? $pair[0]->getRank() : null;

        return ['threeCardsRank' => $threeCardsRank, 'pairRank' => $pairRank];
    }

    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFullHouse(array $cards): bool
    {
        $ranksCards = Hand::getRanksWithTheirCards($cards);

        $threeCards = false;
        $pair = false;

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
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
