<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\HandComparison;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ThreeOfAKindHandComparisonTest extends TestCase
{
    /**
     * @param Card[] $firstHandCards
     * @param Card[] $secondHandCards
     */
    #[Test]
    #[DataProvider('casesProvider')]
    public function canCompareThreeOfAKindHands(
        Hand $firstHand,
        array $firstHandCards,
        Hand $secondHand,
        array $secondHandCards,
        int $expectedResult,
    ): void {
        // Compare the values of the trios.
        // If those values are equal, compare the values of other two cards (the “kickers“),
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
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                ],
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::FIVE, CardSuit::CLUBS),
                ],
                -1,
            ],
            [ // Case with the same trio but different "kickers"
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                    Card::create(CardRank::EIGHT, CardSuit::CLUBS),
                ],
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                    Card::create(CardRank::NINE, CardSuit::CLUBS),
                ],
                -1,
            ],
            [
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::FIVE, CardSuit::CLUBS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                ],
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::CLUBS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                ],
                0,
            ],
            [
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::CLUBS),
                ],
                1,
            ],
            [ // Case with the same trio but different "kickers"
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                ],
                Hand::THREE_OF_A_KIND,
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                ],
                1,
            ],
        ];
    }
}
