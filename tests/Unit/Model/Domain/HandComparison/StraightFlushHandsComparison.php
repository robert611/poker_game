<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use App\Model\Domain\HandComparison\HandComparisonInterface;
use Monolog\Test\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class StraightFlushHandsComparison extends TestCase
{
    #[Test]
    #[DataProvider('casesProvider')]
    public function canCompareStraights(
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
                Hand::STRAIGHT_FLUSH,
                [
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::HEARTS),
                ],
                Hand::STRAIGHT_FLUSH,
                [
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::CLUBS),
                    Card::create(CardRank::TEN, CardSuit::CLUBS),
                    Card::create(CardRank::NINE, CardSuit::CLUBS),
                    Card::create(CardRank::EIGHT, CardSuit::CLUBS),
                ],
                HandComparisonInterface::FIRST_PLAYER_WINS,
            ],
            [
                Hand::STRAIGHT_FLUSH,
                [
                    Card::create(CardRank::TEN, CardSuit::CLUBS),
                    Card::create(CardRank::NINE, CardSuit::CLUBS),
                    Card::create(CardRank::EIGHT, CardSuit::CLUBS),
                    Card::create(CardRank::SEVEN, CardSuit::CLUBS),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                ],
                Hand::STRAIGHT_FLUSH,
                [
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::SEVEN, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::HEARTS),
                ],
                HandComparisonInterface::DRAW,
            ],
            [
                Hand::STRAIGHT_FLUSH,
                [
                    Card::create(CardRank::SEVEN, CardSuit::CLUBS),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                    Card::create(CardRank::FIVE, CardSuit::CLUBS),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                ],
                Hand::STRAIGHT_FLUSH,
                [
                    Card::create(CardRank::NINE, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::SEVEN, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::HEARTS),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                ],
                HandComparisonInterface::SECOND_PLAYER_WINS,
            ],
        ];
    }
}
