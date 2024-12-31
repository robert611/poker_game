<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\Hand\Straight;

class StraightHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        $firstPlayerCards = Straight::getLongestSequenceOfCards($firstPlayerCards);
        $secondPlayerCards = Straight::getLongestSequenceOfCards($secondPlayerCards);

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
