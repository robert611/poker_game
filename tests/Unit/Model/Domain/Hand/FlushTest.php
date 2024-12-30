<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\Flush;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FlushTest extends TestCase
{
    #[Test]
    #[DataProvider('canGetCardsComprisingFlushProvider')]
    public function canGetCardsComprisingFlush(array $cards, array $expectedCards): void
    {
        self::assertEquals($expectedCards, Flush::getCardsComprisingFlush($cards));
    }

    /**
     * @return array<int, array<int, Card[]>>
     */
    public static function canGetCardsComprisingFlushProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                ],
                []
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                ],
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                ],
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                ],
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                ],
            ],
        ];
    }
}
