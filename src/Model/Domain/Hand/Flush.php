<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardSuit;

class Flush
{
    /**
     * @param Card[] $cards
     * @return array<string, Card[]>
     */
    public static function getSuitsCards(array $cards): array
    {
        $suits = [
            CardSuit::HEARTS->value => [],
            CardSuit::DIAMONDS->value => [],
            CardSuit::CLUBS->value => [],
            CardSuit::SPADES->value => [],
        ];

        foreach ($cards as $card) {
            $suits[$card->getSuit()->value][] = $card;
        }

        return $suits;
    }

    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFlush(array $cards): bool
    {
        // A flush is a hand that contains five cards of the same suit,
        // not all of sequential rank

        $suits = self::getSuitsCards($cards);

        foreach ($suits as $suitCards) {
            if (count($suitCards) >= 5) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Card[] $cards
     * @return Card[]
     */
    public static function getCardsComprisingFlush(array $cards): array
    {
        $suits = self::getSuitsCards($cards);

        foreach ($suits as $suitCards) {
            if (count($suitCards) >= 5) {
                // Notice, that 5 strongest card are taken into account
                $sortedCards = Card::sortCardsFromTheHighest($suitCards);

                return array_slice($sortedCards, 0, 5, true);
            }
        }

        return [];
    }
}
