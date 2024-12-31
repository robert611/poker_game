<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;

class Straight
{
    /**
     * @param Card[] $cards
     * @return Card[]
     */
    public static function getLongestSequenceOfCards(array $cards): array
    {
        $cards = Card::sortCardsFromTheHighest($cards);

        $sequences = [[]];

        foreach ($cards as $key => $card) {
            if (false === isset($cards[$key - 1])) {
                $sequences[array_key_last($sequences)][] = $card;
                continue;
            }

            $previousSuitCard = $cards[$key - 1];

            if (CardRank::isRankTheSame($previousSuitCard->getRank(), $card->getRank())) {
                continue;
            }

            $isRankOneSmaller = CardRank::isRankOneSmaller(
                $previousSuitCard->getRank(),
                $card->getRank(),
            );

            if ($isRankOneSmaller) {
                $sequences[array_key_last($sequences)][] = $card;
                continue;
            }

            $sequences[] = [$card];
        }

        $longestSequence = [];

        // Extract the longest sequence
        // Note that sequences are sorted from one with the highest cards
        foreach ($sequences as $sequence) {
            if (count($sequence) > count($longestSequence)) {
                $longestSequence = $sequence;
            }
        }

        return $longestSequence;
    }

    /**
     * @param Card[] $cards
     */
    public static function isRecognizedStraight(array $cards): bool
    {
        // A straight in Hold 'Em is the same as a straight in other poker games:
        // five cards, of more than one suit, in sequence (e.g., 5,6,7,8,9)

        $longestSequence = self::getLongestSequenceOfCards($cards);

        if (count($longestSequence) >= 5) {
            return true;
        }

        return false;
    }
}
