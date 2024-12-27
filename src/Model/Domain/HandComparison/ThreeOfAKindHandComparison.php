<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\Hand\ThreeOfAKind;

class ThreeOfAKindHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        $firstPlayerRank = ThreeOfAKind::getThreeOfAKindCardsRank($firstPlayerCards);
        $secondPlayerRank = ThreeOfAKind::getThreeOfAKindCardsRank($secondPlayerCards);

        if ($firstPlayerRank !== $secondPlayerRank) {
            if ($firstPlayerRank->getStrength() > $secondPlayerRank->getStrength()) {
                return self::FIRST_PLAYER_WINS;
            }

            return self::SECOND_PLAYER_WINS;
        }

        // Now, must compare rest of the cards
        $firstPlayerLeftOverCards = Card::sortCardsFromTheHighest(ThreeOfAKind::getLeftOverCards($firstPlayerCards));
        $secondPlayerLeftOverCards = Card::sortCardsFromTheHighest(ThreeOfAKind::getLeftOverCards($secondPlayerCards));

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
