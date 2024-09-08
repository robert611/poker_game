<?php

namespace App\Tests\Unit\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DifferentHandsComparisonTest extends TestCase
{
    /**
     * @param Card[] $firstHandCards
     * @param Card[] $secondHandCards
     */
    #[Test]
    #[DataProvider('casesProvider')]
    public function canCompareDifferentHands(
        Hand $firstHand,
        array $firstHandCards,
        Hand $secondHand,
        array $secondHandCards,
        int $expectedResult,
    ): void {
        $result = Hand::compareHands($firstHand, $firstHandCards, $secondHand, $secondHandCards);

        self::assertSame($expectedResult, $result);
    }

    public static function casesProvider(): array
    {
        return [
            [
                Hand::FLUSH,
                [],
                Hand::ROYAL_FLUSH,
                [],
                -1,
            ],
            [
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                ],
                Hand::TWO_PAIRS,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                ],
                0,
            ],
            [
                Hand::THREE_OF_A_KIND,
                [],
                Hand::TWO_PAIRS,
                [],
                1,
            ],
        ];
    }
}
