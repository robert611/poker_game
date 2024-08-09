<?php

namespace App\Model\Domain;

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
     * @param Card[] $cards
     */
    public static function recognizeHand(array $cards): Hand
    {
        return match (true) {
            self::isRecognizedRoyalFlush($cards) => Hand::ROYAL_FLUSH,
            self::isRecognizedStraightFlush($cards) => Hand::STRAIGHT_FLUSH,
            self::isRecognizedFourOfAKind($cards) => Hand::FOUR_OF_A_KIND,
            self::isRecognizedFullHouse($cards) => Hand::FULL_HOUSE,
            self::isRecognizedFlush($cards) => Hand::FLUSH,
            self::isRecognizedStraight($cards) => Hand::STRAIGHT,
            self::isRecognizedThreeOfAKind($cards) => Hand::THREE_OF_A_KIND,
            self::isRecognizedTwoPairs($cards) => Hand::TWO_PAIRS,
            self::isRecognizedOnePair($cards) => Hand::PAIR,
            default => Hand::HIGHEST_CARD,
        };
    }

    /**
     * Function returns
     * -1 if $firstHand is weaker than $secondHand
     * 0 if they are equal
     * 1 if $firstHand is stronger than $secondHand
     */
    public static function compareHands(
        Hand $firstHand,
        array $firstHandCards,
        Hand $secondHand,
        array $secondHandCards,
    ): int {
        if ($firstHand->value !== $secondHand->value) {
            return $firstHand->value <=> $secondHand->value;
        }

        if ($firstHand === Hand::HIGHEST_CARD) {
            $firstHandHighestCard = Card::getHighestCard($firstHandCards);
            $secondHandHighestCard = Card::getHighestCard($secondHandCards);

            return $firstHandHighestCard->getRank()->getStrength() <=> $secondHandHighestCard->getRank()->getStrength();
        }

        return 0;
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

    /**
     * @param Card[] $cards
     */
    public static function isRecognizedThreeOfAKind(array $cards): bool
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
            if (count($rankCards) === 3) {
                return true;
            }
        }

        return false;
    }

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
     * @param Card[] $cards
     */
    public static function isRecognizedOnePair(array $cards): bool
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
            if (count($rankCards) === 2) {
                return true;
            }
        }

        return false;
    }
}
