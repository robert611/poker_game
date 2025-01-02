<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\Hand\FourOfAKind;

class FourOfAKindHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        $firstPlayerFourOfAKindRank = FourOfAKind::getFourOfAKindRank($firstPlayerCards);
        $secondPlayerFourOfAKindRank = FourOfAKind::getFourOfAKindRank($secondPlayerCards);

        if ($firstPlayerFourOfAKindRank !== $secondPlayerFourOfAKindRank) {
            return $firstPlayerFourOfAKindRank->getStrength() <=> $secondPlayerFourOfAKindRank->getStrength();
        }

        $firstPlayerLeftOverCards = Card::sortCardsFromTheHighest(FourOfAKind::getLeftOverCards($firstPlayerCards));
        $secondPlayerLeftOverCards = Card::sortCardsFromTheHighest(FourOfAKind::getLeftOverCards($secondPlayerCards));

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
