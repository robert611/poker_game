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

class FullHouseHandsComparisonTest extends TestCase
{
    /**
     * @param Card[] $firstHandCards
     * @param Card[] $secondHandCards
     */
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
                Hand::FULL_HOUSE,
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                ],
                Hand::FULL_HOUSE,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                ],
                HandComparisonInterface::FIRST_PLAYER_WINS,
            ],
            [
                Hand::FULL_HOUSE,
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                ],
                Hand::FULL_HOUSE,
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                ],
                HandComparisonInterface::DRAW,
            ],
            [
                Hand::FULL_HOUSE,
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                ],
                Hand::FULL_HOUSE,
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::CLUBS),
                    Card::create(CardRank::NINE, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
                HandComparisonInterface::SECOND_PLAYER_WINS,
            ],
        ];
    }
}
