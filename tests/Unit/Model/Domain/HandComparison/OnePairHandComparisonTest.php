<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use App\Model\Domain\HandComparison\HandComparisonInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OnePairHandComparisonTest extends TestCase
{
    /**
     * @param Card[] $firstHandCards
     * @param Card[] $secondHandCards
     */
    #[Test]
    #[DataProvider('casesProvider')]
    public function canCompareOnePairHands(
        Hand $firstHand,
        array $firstHandCards,
        Hand $secondHand,
        array $secondHandCards,
        int $expectedResult,
    ): void {
        // Compare the values of one pair.
        // If those values are equal, compare the values rest of the cards,
        // starting with the highest one.
        // Continue comparing kickers until a kicker from one hand is higher than the other’s.
        // If no kicker breaks the tie, and all cards have been compared, then both hands are equal.
        $result = Hand::compareHands($firstHand, $firstHandCards, $secondHand, $secondHandCards);

        self::assertSame($expectedResult, $result);
    }

    public static function casesProvider(): array
    {
        return [
            [
                Hand::PAIR,
                [
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                ],
                Hand::PAIR,
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                ],
                HandComparisonInterface::FIRST_PLAYER_WINS,
            ],
            [
                Hand::PAIR,
                [
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
                Hand::PAIR,
                [
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                ],
                HandComparisonInterface::DRAW,
            ],
            [
                Hand::PAIR,
                [
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
                Hand::PAIR,
                [
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                ],
                HandComparisonInterface::SECOND_PLAYER_WINS,
            ],
            [
                Hand::PAIR,
                [
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                ],
                Hand::PAIR,
                [
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                ],
                HandComparisonInterface::FIRST_PLAYER_WINS,
            ],
            [
                Hand::PAIR,
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                ],
                Hand::PAIR,
                [
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                ],
                HandComparisonInterface::DRAW,
            ],
            [
                Hand::PAIR,
                [
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                ],
                Hand::PAIR,
                [
                    Card::create(CardRank::SEVEN, CardSuit::CLUBS),
                    Card::create(CardRank::SEVEN, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                ],
                HandComparisonInterface::SECOND_PLAYER_WINS,
            ],
        ];
    }
}
