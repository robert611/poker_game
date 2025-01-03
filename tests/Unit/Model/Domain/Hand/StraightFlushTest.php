<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\StraightFlush;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StraightFlushTest extends TestCase
{
    #[Test]
    #[DataProvider('canGetCardsComprisingStraightFlushProvider')]
    public function canGetCardsComprisingStraightFlush(array $cards, array $expectedCards): void
    {
        self::assertEquals($expectedCards, StraightFlush::getCardsComprisingStraightFlush($cards));
    }

    public static function canGetCardsComprisingStraightFlushProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                ],
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                ],
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                ],
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                ],
            ],
        ];
    }
}
