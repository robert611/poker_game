<?php

namespace App\Tests\Unit\Model\Domain;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    /**
     * @test
     *
     * @param Card[] $cards
     *
     * @dataProvider getHighestCardProvider
     */
    public function canGetHighesCard(array $cards, ?Card $expectedHighestCard): void
    {
        $highestCard = Card::getHighestCard($cards);

        self::assertEquals($expectedHighestCard?->getRank(), $highestCard?->getRank());
    }

    /**
     * @test
     */
    public function canGetPairsCards(): void
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

        $pairsCards = Card::getPairsCardsRanks($cards);

        self::assertSame(CardRank::FOUR, $pairsCards[0]);
        self::assertSame(CardRank::FIVE, $pairsCards[1]);
        self::assertSame(CardRank::JACK, $pairsCards[2]);
    }

    public function getHighestCardProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                ],
                Card::create(CardRank::JACK, CardSuit::DIAMONDS),
            ],
            [
                [
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::SEVEN, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                ],
                Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
            ],
            [
                [],
                null,
            ],
        ];
    }
}
