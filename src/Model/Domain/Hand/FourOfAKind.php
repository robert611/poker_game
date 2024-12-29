<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
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
}
