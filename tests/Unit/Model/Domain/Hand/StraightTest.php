<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\Straight;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StraightTest extends TestCase
{
    #[Test]
    #[DataProvider('canGetLongestSequenceOfCardsProvider')]
    public function canGetLongestSequenceOfCards(array $cards, array $cardRank): void
    {
        self::assertEquals($cardRank, Straight::getLongestSequenceOfCards($cards));
    }

    /**
     * @return array<int, Card[]>
     */
    public static function canGetLongestSequenceOfCardsProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                ],
            ],
            [
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                ],
            ],
            [
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                ],
            ],
            [
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                ],
            ],
        ];
    }
}
