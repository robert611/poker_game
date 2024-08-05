<?php

namespace App\Model;

enum Hand: int
{
    case HIGHEST_CARD = 1;
    case PAIR = 2;
    case TWO_PAIRS = 3;
    case THREE_OF_A_KIND = 4;
    case STRAIGHT = 5;
    case FLUSH = 6;
    case FULL_HOUSE = 7;
    case FOUR_OF_A_KIND = 8;
    case STRAIGHT_FLUSH = 9;
    case ROYAL_FLUSH = 10;

    public function translate(): string
    {
        return match ($this) {
            self::HIGHEST_CARD => 'Najwyższa karta',
            self::PAIR => 'Para',
            self::TWO_PAIRS => 'Dwie pary',
            self::THREE_OF_A_KIND => 'Trójka',
            self::STRAIGHT => 'Street',
            self::FLUSH => 'Strit',
            self::FULL_HOUSE => 'Full',
            self::FOUR_OF_A_KIND => 'Kareta',
            self::STRAIGHT_FLUSH => 'Mały poker',
            self::ROYAL_FLUSH => 'Poker królewski',
        };
    }

    /**
     * @param Card[] $playerCards
     * @param Card[] $dealtCards
     */
    public static function recognizeHand(array $playerCards, array $dealtCards, Card $turn, Card $river): Hand
    {
        $allCards = array_merge($playerCards, $dealtCards, [$turn, $river]);

        return match (true) {
            self::isRecognizedRoyalFlush($allCards) => Hand::ROYAL_FLUSH,
            self::isRecognizedStraightFlush($allCards) => Hand::STRAIGHT_FLUSH,
            self::isRecognizedFourOfAKind($allCards) => Hand::FOUR_OF_A_KIND,
            self::isRecognizedFullHouse($allCards) => Hand::FULL_HOUSE,
            self::isRecognizedFlush($allCards) => Hand::FLUSH,
            self::isRecognizedStraight($allCards) => Hand::STRAIGHT,
            self::isRecognizedThreeOfAKind($allCards) => Hand::THREE_OF_A_KIND,
            self::isRecognizedTwoPairs($allCards) => Hand::TWO_PAIRS,
            self::isRecognizedOnePair($allCards) => Hand::PAIR,
            default => Hand::HIGHEST_CARD,
        };
    }

    public static function compareHands(): bool
    {
        return true;
    }

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

            $suitCards = Card::sortCardsFromLowest($suitCards);

            $cardsInOrder = 0;

            foreach ($suitCards as $key => $currentSuitCard) {
                if (false === isset($suitCards[$key - 1])) {
                    $cardsInOrder = 1;
                    continue;
                }

                $previousSuitCard = $suitCards[$key - 1];

                $isRankOneBigger = CardRank::isRankOneBigger(
                    $previousSuitCard->getRank(),
                    $currentSuitCard->getRank(),
                );

                if ($isRankOneBigger) {
                    $cardsInOrder += 1;
                    continue;
                }

                $cardsInOrder = 0;
            }

            if ($cardsInOrder >= 5) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFourOfAKind(array $cards): bool
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

        /** @var Card[] $rankCards */
        foreach ($ranks as $rankCards) {
            if (count($rankCards) === 4) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Card[] $cards
     */
    public static function isRecognizedFullHouse(array $cards): bool
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

        $threeCards = false;
        $pair = false;

        /** @var Card[] $rankCards */
        foreach ($ranks as $rankCards) {
            if (count($rankCards) === 3) {
                $threeCards = true;
            }

            if (count($rankCards) === 2) {
                $pair = true;
            }
        }

        if ($threeCards && $pair) {
            return true;
        }

        return false;
    }

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
