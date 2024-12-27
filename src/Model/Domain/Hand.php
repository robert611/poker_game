<?php

declare(strict_types=1);

namespace App\Model\Domain;

use App\Model\Domain\Hand\Flush;
use App\Model\Domain\Hand\FourOfAKind;
use App\Model\Domain\Hand\FullHouse;
use App\Model\Domain\Hand\HighestCard;
use App\Model\Domain\Hand\Pair;
use App\Model\Domain\Hand\Straight;
use App\Model\Domain\Hand\ThreeOfAKind;
use App\Model\Domain\Hand\TwoPairs;
use App\Model\Domain\HandComparison\ThreeOfAKindHandComparison;

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
            FourOfAKind::isRecognizedFourOfAKind($cards) => Hand::FOUR_OF_A_KIND,
            FullHouse::isRecognizedFullHouse($cards) => Hand::FULL_HOUSE,
            Flush::isRecognizedFlush($cards) => Hand::FLUSH,
            Straight::isRecognizedStraight($cards) => Hand::STRAIGHT,
            ThreeOfAKind::isRecognizedThreeOfAKind($cards) => Hand::THREE_OF_A_KIND,
            TwoPairs::isRecognizedTwoPairs($cards) => Hand::TWO_PAIRS,
            Pair::isRecognizedOnePair($cards) => Hand::PAIR,
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
            $firstHandHighestCard = HighestCard::getHighestCard($firstHandCards);
            $secondHandHighestCard = HighestCard::getHighestCard($secondHandCards);

            return $firstHandHighestCard->getRank()->getStrength() <=> $secondHandHighestCard->getRank()->getStrength();
        }

        if ($firstHand === Hand::PAIR) {
            return 0; // Unfinished
        }

        if ($firstHand === Hand::TWO_PAIRS) {
            $firstHandPairsRanks = TwoPairs::getPairsCardsRanks($firstHandCards);
            $secondHandPairsRanks = TwoPairs::getPairsCardsRanks($secondHandCards);

            $firstHandPairsRanks = CardRank::sortRanksFromBiggest($firstHandPairsRanks);
            $secondHandPairsRanks = CardRank::sortRanksFromBiggest($secondHandPairsRanks);

            if ($firstHandPairsRanks[0] !== $secondHandPairsRanks[0]) {
                return $firstHandPairsRanks[0]->getStrength() <=> $secondHandPairsRanks[0]->getStrength();
            }

            if ($firstHandPairsRanks[1] !== $secondHandPairsRanks[1]) {
                return $firstHandPairsRanks[1]->getStrength() <=> $secondHandPairsRanks[1]->getStrength();
            }

            return 0;
        }

        if ($firstHand === Hand::THREE_OF_A_KIND) {
            return ThreeOfAKindHandComparison::compare($firstHandCards, $secondHandCards);
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
}
