<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\ThreeOfAKind;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ThreeOfAKindTest extends TestCase
{
    #[Test]
    #[DataProvider('canGetThreeOfAKindCardsRankProvider')]
    public function canGetThreeOfAKindCardsRank(array $cards, ?CardRank $cardRank): void
    {
        self::assertEquals($cardRank, ThreeOfAKind::getThreeOfAKindCardsRank($cards));
    }

    #[Test]
    #[DataProvider('canGetLeftOverCardsProvider')]
    public function canGetLeftOverCards(array $cards, array $leftOverCards): void
    {
        self::assertEquals($leftOverCards, ThreeOfAKind::getLeftOverCards($cards));
    }

    public static function canGetThreeOfAKindCardsRankProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::SPADES),
                ],
                null,
            ],
            [
                [
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                CardRank::QUEEN,
            ],
            [
                [
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                CardRank::QUEEN,
            ],
            [
                [
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                ],
                CardRank::QUEEN,
            ],
            [
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                ],
                CardRank::ACE,
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
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
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
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                ],
                [],
            ],
            [
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
            ],
        ];
    }
}
