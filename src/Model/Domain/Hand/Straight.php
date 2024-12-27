<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;

class Straight
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedStraight(array $cards): bool
    {
        // A straight in Hold 'Em is the same as a straight in other poker games:
        // five cards, of more than one suit, in sequence (e.g., 5,6,7,8,9)

        $cards = Card::sortCardsFromLowest($cards);

        $cardsInOrder = 0;

        foreach ($cards as $key => $card) {
            if (false === isset($cards[$key - 1])) {
                $cardsInOrder = 1;
                continue;
            }

            $previousSuitCard = $cards[$key - 1];

            if (CardRank::isRankTheSame($previousSuitCard->getRank(), $card->getRank())) {
                continue;
            }

            $isRankOneBigger = CardRank::isRankOneBigger(
                $previousSuitCard->getRank(),
                $card->getRank(),
            );

            if ($isRankOneBigger) {
                $cardsInOrder += 1;
                continue;
            }

            if ($cardsInOrder >= 5) {
                return true; // Do not go further as it's not necessary and could cause $cardInOrder to be reset
            }

            $cardsInOrder = 0;
        }

        if ($cardsInOrder >= 5) {
            return true;
        }

        return false;
    }
}
