<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\Pair;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OnePairTest extends TestCase
{
    #[Test]
    #[DataProvider('canGetOnePairCardsRankProvider')]
    public function canGetOnePairCardsRank(array $cards, ?CardRank $cardRank): void
    {
        self::assertEquals($cardRank, Pair::getOnePairCardsRank($cards));
    }

    #[Test]
    #[DataProvider('canGetLeftOverCardsProvider')]
    public function canGetLeftOverCards(array $cards, array $leftOverCards): void
    {
        self::assertEquals($leftOverCards, Pair::getLeftOverCards($cards));
    }

    public static function canGetOnePairCardsRankProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                ],
                null,
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                CardRank::KING,
            ],
            [
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                ],
                CardRank::FOUR,
            ],
            [
                [
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::SIX, CardSuit::CLUBS),
                ],
                CardRank::SIX,
            ],
        ];
    }

    public static function canGetLeftOverCardsProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                ],
                [
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                ],
            ],
            [
                [
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                ],
                [
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                ],
                [
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                ],
            ],
        ];
    }
}
