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

class FlushHandComparison extends TestCase
{
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
                [
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                ],
                Hand::FLUSH,
                [
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                ],
                HandComparisonInterface::FIRST_PLAYER_WINS,
            ],
            [
                Hand::FLUSH,
                [
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                ],
                Hand::FLUSH,
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
                HandComparisonInterface::DRAW,
            ],
            [
                Hand::FLUSH,
                [
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                ],
                Hand::FLUSH,
                [
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
                HandComparisonInterface::SECOND_PLAYER_WINS,
            ],
        ];
    }
}
