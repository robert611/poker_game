<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use PHPUnit\Framework\TestCase;

class TwoPairsHandComparisonTest extends TestCase
{
    /**
     * @test
     * @dataProvider casesProvider
     */
    public function canCompareTwoPairsHands(
        Hand $firstHand,
        array $firstHandCards,
        Hand $secondHand,
        array $secondHandCards,
        int $expectedResult,
    ): void {
        $result = Hand::compareHands($firstHand, $firstHandCards, $secondHand, $secondHandCards);

        self::assertSame($expectedResult, $result);
    }

    public function casesProvider(): array
    {
        return [
            [
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::CLUBS),
                ],
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::HEARTS),
                ],
                -1,
            ],
            [
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                ],
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                ],
                0,
            ],
            [
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::CLUBS),
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                ],
                1,
            ],
        ];
    }
}
