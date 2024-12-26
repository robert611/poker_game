<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;

class TwoPairs
{
    /**
     * @param Card[] $cards
     */
    public static function isRecognizedTwoPairs(array $cards): bool
    {
        $ranks = [
            CardRank::ACE->value => [],
            CardRank::KING->value => [],
            CardRank::QUEEN->value => [],
            CardRank::JACK->value => [],
            CardRank::TEN->value => [],
            CardRank::NINE->value => [],
            CardRank::EIGHT->value => [],
            CardRank::SEVEN->value => [],
            CardRank::SIX->value => [],
            CardRank::FIVE->value => [],
            CardRank::FOUR->value => [],
            CardRank::THREE->value => [],
            CardRank::TWO->value => [],
        ];

        foreach ($cards as $card) {
            $ranks[$card->getRank()->value][] = $card;
        }

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
}
