<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\Hand\TwoPairs;

class TwoPairsHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        $firstHandPairsRanks = TwoPairs::getPairsCardsRanks($firstPlayerCards);
        $secondHandPairsRanks = TwoPairs::getPairsCardsRanks($secondPlayerCards);

        $firstHandPairsRanks = CardRank::sortRanksFromBiggest($firstHandPairsRanks);
        $secondHandPairsRanks = CardRank::sortRanksFromBiggest($secondHandPairsRanks);

        if ($firstHandPairsRanks[0] !== $secondHandPairsRanks[0]) {
            return $firstHandPairsRanks[0]->getStrength() <=> $secondHandPairsRanks[0]->getStrength();
        }

        if ($firstHandPairsRanks[1] !== $secondHandPairsRanks[1]) {
            return $firstHandPairsRanks[1]->getStrength() <=> $secondHandPairsRanks[1]->getStrength();
        }

        // Both of the two pairs are of identical rank, compare kickers
        $firstPlayerLeftOverCards = Card::sortCardsFromTheHighest(TwoPairs::getLeftOverCards($firstPlayerCards));
        $secondPlayerLeftOverCards = Card::sortCardsFromTheHighest(TwoPairs::getLeftOverCards($secondPlayerCards));

        for ($i = 0; $i < count($firstPlayerLeftOverCards); $i++) {
            if (false === isset($secondPlayerLeftOverCards[$i])) {
                return self::FIRST_PLAYER_WINS;
            }

            $firstPlayerCartStrength = $firstPlayerLeftOverCards[$i]->getRank()->getStrength();
            $secondPlayerCartStrength = $secondPlayerLeftOverCards[$i]->getRank()->getStrength();

            if ($firstPlayerCartStrength > $secondPlayerCartStrength) {
                return self::FIRST_PLAYER_WINS;
            } else if ($firstPlayerCartStrength < $secondPlayerCartStrength) {
                return self::SECOND_PLAYER_WINS;
            }
        }

        return self::DRAW;
    }
}
