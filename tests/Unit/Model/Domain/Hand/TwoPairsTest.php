<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\TwoPairs;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TwoPairsTest extends TestCase
{
    #[Test] public function canGetPairsCards(): void
    {
        $cards = [
            Card::create(CardRank::ACE, CardSuit::CLUBS),
            Card::create(CardRank::FIVE, CardSuit::HEARTS),
            Card::create(CardRank::JACK, CardSuit::DIAMONDS),
            Card::create(CardRank::JACK, CardSuit::HEARTS),
            Card::create(CardRank::JACK, CardSuit::CLUBS),
            Card::create(CardRank::FOUR, CardSuit::HEARTS),
            Card::create(CardRank::FIVE, CardSuit::SPADES),
            Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
            Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
        ];

        $pairsCards = TwoPairs::getPairsCardsRanks($cards);

        self::assertSame(CardRank::FOUR, $pairsCards[0]);
        self::assertSame(CardRank::FIVE, $pairsCards[1]);
        self::assertSame(CardRank::JACK, $pairsCards[2]);
    }

    #[Test]
    #[DataProvider('canGetLeftOverCardsProvider')]
    public function canGetLeftOverCards(array $cards, array $leftOverCards): void
    {
        self::assertEquals($leftOverCards, TwoPairs::getLeftOverCards($cards));
    }

    public static function canGetLeftOverCardsProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
            ],
            [
                [
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
            ],
            [
                [
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                ],
            ],
        ];
    }
}
