<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\Hand\StraightFlush;

class StraightFlushHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        // Suit does not matter. The suit of a flush does not affect the value.
        // If two players have a flush, they compare the largest value card in the flush to
        // determine the winner. If the highest value card is the same, they compare their next
        // highest cards.

        $firstPlayerCards = StraightFlush::getCardsComprisingStraightFlush($firstPlayerCards);
        $secondPlayerCards = StraightFlush::getCardsComprisingStraightFlush($secondPlayerCards);

        $firstPlayerCards = Card::sortCardsFromTheHighest($firstPlayerCards);
        $secondPlayerCards = Card::sortCardsFromTheHighest($secondPlayerCards);

        for ($i = 0; $i < count($firstPlayerCards); $i++) {
            if (false === isset($secondPlayerCards[$i])) {
                return self::FIRST_PLAYER_WINS;
            }

            $firstPlayerCartStrength = $firstPlayerCards[$i]->getRank()->getStrength();
            $secondPlayerCartStrength = $secondPlayerCards[$i]->getRank()->getStrength();

            if ($firstPlayerCartStrength > $secondPlayerCartStrength) {
                return self::FIRST_PLAYER_WINS;
            } else if ($firstPlayerCartStrength < $secondPlayerCartStrength) {
                return self::SECOND_PLAYER_WINS;
            }
        }

        return self::DRAW;
    }
}
