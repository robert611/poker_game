<?php

declare(strict_types=1);

namespace App\Model\Domain;

use App\Model\Domain\Hand\Flush;
use App\Model\Domain\Hand\FourOfAKind;
use App\Model\Domain\Hand\FullHouse;
use App\Model\Domain\Hand\HighestCard;
use App\Model\Domain\Hand\Pair;
use App\Model\Domain\Hand\RoyalFlush;
use App\Model\Domain\Hand\Straight;
use App\Model\Domain\Hand\StraightFlush;
use App\Model\Domain\Hand\ThreeOfAKind;
use App\Model\Domain\Hand\TwoPairs;
use App\Model\Domain\HandComparison\FlushHandComparison;
use App\Model\Domain\HandComparison\OnePairHandComparison;
use App\Model\Domain\HandComparison\StraightHandComparison;
use App\Model\Domain\HandComparison\ThreeOfAKindHandComparison;
use App\Model\Domain\HandComparison\TwoPairsHandComparison;

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
            RoyalFlush::isRecognizedRoyalFlush($cards) => Hand::ROYAL_FLUSH,
            StraightFlush::isRecognizedStraightFlush($cards) => Hand::STRAIGHT_FLUSH,
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
            return OnePairHandComparison::compare($firstHandCards, $secondHandCards);
        }

        if ($firstHand === Hand::TWO_PAIRS) {
            return TwoPairsHandComparison::compare($firstHandCards, $secondHandCards);
        }

        if ($firstHand === Hand::THREE_OF_A_KIND) {
            return ThreeOfAKindHandComparison::compare($firstHandCards, $secondHandCards);
        }

        if ($firstHand === Hand::STRAIGHT) {
            return 0;
        }

        if ($firstHand === Hand::FLUSH) {
            return FlushHandComparison::compare($firstHandCards, $secondHandCards);
        }

        return 0;
    }

    /**
     * @param Card[] $cards
     * @return array<int, Card[]>
     */
    public static function getRanksWithTheirCards(array $cards): array
    {
        $ranksCards = [
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
            $ranksCards[$card->getRank()->value][] = $card;
        }

        return $ranksCards;
    }
}
