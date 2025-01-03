<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;

class StraightFlush
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedStraightFlush(array $cards): bool
    {
        // To have straight flush you need five cards in numerical order, all of identical suits.

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
            if (count($suitCards) < 5) {
                continue; // Must be at least five cards of the same suit
            }

            $suitCards = Card::sortCardsFromTheHighest($suitCards);

            $cardsInOrder = 0;

            foreach ($suitCards as $key => $currentSuitCard) {
                if (false === isset($suitCards[$key - 1])) {
                    $cardsInOrder = 1;
                    continue;
                }

                $previousSuitCard = $suitCards[$key - 1];

                $isRankOneBigger = CardRank::isRankOneSmaller(
                    $previousSuitCard->getRank(),
                    $currentSuitCard->getRank(),
                );

                if ($isRankOneBigger) {
                    $cardsInOrder += 1;

                    if ($cardsInOrder === 5) {
                        return true;
                    }

                    continue;
                }

                $cardsInOrder = 0;
            }
        }

        return false;
    }
}
