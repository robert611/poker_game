<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\Hand;

class TwoPairs
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedTwoPairs(array $cards): bool
    {
        $ranks = Hand::getRanksWithTheirCards($cards);

        $ranksWithTwoCards = 0;

        /** @var Card[] $rankCards */
        foreach ($ranks as $rankCards) {
            if (count($rankCards) === 2) {
                $ranksWithTwoCards += 1;
            }
        }

        if ($ranksWithTwoCards >= 2) {
            return true;
        }

        return false;
    }

    /**
     * Purpose of the function is to find all the cards that have pairs
     * For instance two aces and two jacks would return an array comprised of an ace and a jack
     * in ascending order
     *
     * @param Card[] $cards
     *
     * @return CardRank[]
     */
    public static function getPairsCardsRanks(array $cards): array
    {
        $pairsCards = [];

        $cards = Card::sortCardsFromLowest($cards);

        foreach ($cards as $key => $card) {
            if (false === isset($cards[$key + 1])) {
                break;
            }

            $nextCard = $cards[$key + 1];

            if ($card->getRank() === $nextCard->getRank()) {
                $lastAddedRank = count($pairsCards) > 0 ? $pairsCards[count($pairsCards) - 1] : null;

                if ($lastAddedRank !== $card->getRank()) {
                    $pairsCards[] = $card->getRank();
                }
            }
        }

        return $pairsCards;
    }

    /**
     * @param Card[] $cards
     * @return Card[]
     */
    public static function getLeftOverCards(array $cards): array
    {
        $pairsCardsRanks = self::getPairsCardsRanks($cards);
        $pairsCardsRanks = CardRank::sortRanksFromBiggest($pairsCardsRanks);

        // In texas hold'em there are 7 cards, so it's possible to have 3 pairs, but only two strongest pairs are
        // taken into account, so I remove third pair if there is one and treat it as leftover cards
        if (count($pairsCardsRanks) > 2) {
            unset($pairsCardsRanks[array_key_last($pairsCardsRanks)]);
        }

        $ranksCards = Hand::getRanksWithTheirCards($cards);

        $leftOverCards = [];

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (0 === count($rankCards)) {
                continue;
            }

            if (false === in_array($rankCards[0]->getRank(), $pairsCardsRanks)) {
                $leftOverCards = array_merge($leftOverCards, $rankCards);
            }
        }

        $result = [];

        // Keep the original cards order in result array
        foreach ($cards as $card) {
            foreach ($leftOverCards as $leftOverCard) {
                if ($card === $leftOverCard) {
                    $result[] = $leftOverCard;
                }
            }
        }

        return $result;
    }
}
