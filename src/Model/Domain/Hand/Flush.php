<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardSuit;

class Flush
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFlush(array $cards): bool
    {
        // A flush is a hand that contains five cards of the same suit,
        // not all of sequential rank

        $suits = [
            CardSuit::HEARTS->value => [],
            CardSuit::DIAMONDS->value => [],
            CardSuit::CLUBS->value => [],
            CardSuit::SPADES->value => [],
        ];

        foreach ($cards as $card) {
            $suits[$card->getSuit()->value][] = $card;
        }

        foreach ($suits as $suitCards) {
            if (count($suitCards) >= 5) {
                return true;
            }
        }

        return false;
    }
}
