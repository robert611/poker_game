<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\HighestCard;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class HighestCardTest extends TestCase
{
    /**
     * @param Card[] $cards
     */
    #[Test]
    #[DataProvider('getHighestCardProvider')]
    public function canGetHighestCard(array $cards, ?Card $expectedHighestCard): void
    {
        $highestCard = HighestCard::getHighestCard($cards);

        self::assertEquals($expectedHighestCard?->getRank(), $highestCard?->getRank());
    }

    public static function getHighestCardProvider(): array
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
