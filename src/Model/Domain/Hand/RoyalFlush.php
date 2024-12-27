<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;

class RoyalFlush
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedRoyalFlush(array $cards): bool
    {
        // To have a Royal Flush, you need an Ace, a King, a Queen, a Jack, and a 10. All the cards that compose
        // the hand need to be of the same suit.

        $royalRanks = [
            CardRank::TEN,
            CardRank::JACK,
            CardRank::QUEEN,
            CardRank::KING,
            CardRank::ACE,
        ];

        $suits = [
            CardSuit::HEARTS->value => [],
            CardSuit::DIAMONDS->value => [],
            CardSuit::CLUBS->value => [],
            CardSuit::SPADES->value => [],
        ];

        foreach ($cards as $card) {
            if (in_array($card->getRank(), $royalRanks)) {
                $suits[$card->getSuit()->value][] = $card;
            }
        }

        foreach ($suits as $suitCards) {
            if (count($suitCards) === 5) {
                return true; // There is five cards of the same color, including only royal flush ranks, we have a match
            }
        }

        return false;
    }
}
