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

class FourOfAKindHandComparison extends TestCase
{
    /**
     * @param Card[] $firstHandCards
     * @param Card[] $secondHandCards
     */
    #[Test]
    #[DataProvider('casesProvider')]
    public function canCompareFourOfAKind(
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
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::CLUBS),
                ],
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                ],
                HandComparisonInterface::FIRST_PLAYER_WINS,
            ],
            [
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                ],
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                ],
                HandComparisonInterface::DRAW,
            ],
            [
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                ],
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                ],
                HandComparisonInterface::DRAW,
            ],
            [
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                ],
                Hand::FOUR_OF_A_KIND,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::HEARTS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                ],
                HandComparisonInterface::SECOND_PLAYER_WINS,
            ],
        ];
    }
}
