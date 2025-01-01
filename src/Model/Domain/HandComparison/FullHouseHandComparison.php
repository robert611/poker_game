<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

use App\Model\Domain\CardRank;
use App\Model\Domain\Hand\FullHouse;

class FullHouseHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        $firstPlayerCards = FullHouse::getFullHouseCardsRanks($firstPlayerCards);
        $secondPlayerCards = FullHouse::getFullHouseCardsRanks($secondPlayerCards);

        /** @var CardRank $firstPlayerThreeOfAKindRank */
        $firstPlayerThreeOfAKindRank = $firstPlayerCards['threeCardsRank'];
        /** @var CardRank $firstPlayerPairRank */
        $firstPlayerPairRank = $firstPlayerCards['pairRank'];

        /** @var CardRank $secondPlayerThreeOfAKindRank */
        $secondPlayerThreeOfAKindRank = $secondPlayerCards['threeCardsRank'];
        /** @var CardRank $secondPlayerPairRank */
        $secondPlayerPairRank = $secondPlayerCards['pairRank'];

        if ($firstPlayerThreeOfAKindRank !== $secondPlayerThreeOfAKindRank) {
            return $firstPlayerThreeOfAKindRank->getStrength() <=> $secondPlayerThreeOfAKindRank->getStrength();
        }

        if ($firstPlayerPairRank !== $secondPlayerPairRank) {
            return $firstPlayerPairRank->getStrength() <=> $secondPlayerPairRank->getStrength();
        }

        return self::DRAW;
    }
}
