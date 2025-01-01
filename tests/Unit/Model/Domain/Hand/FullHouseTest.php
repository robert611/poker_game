<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\FullHouse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FullHouseTest extends TestCase
{
    #[Test]
    #[DataProvider('canGetFullHouseCardsProvider')]
    public function canGetFullHouseCards(array $cards, array $expectedResult): void
    {
        self::assertEquals($expectedResult, FullHouse::getFullHouseCards($cards));
    }

    #[Test]
    #[DataProvider('canGetFullHouseCardsRanksProvider')]
    public function canGetFullHouseCardsRanks(array $cards, array $expectedResult): void
    {
        self::assertEquals($expectedResult, FullHouse::getFullHouseCardsRanks($cards));
    }

    public static function canGetFullHouseCardsProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                ],
                [
                    'threeCards' => [
                        Card::create(CardRank::KING, CardSuit::DIAMONDS),
                        Card::create(CardRank::KING, CardSuit::SPADES),
                        Card::create(CardRank::KING, CardSuit::HEARTS),
                    ],
                    'pair' => [
                        Card::create(CardRank::TEN, CardSuit::HEARTS),
                        Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    ],
                ],
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
                [
                    'threeCards' => [
                        Card::create(CardRank::KING, CardSuit::DIAMONDS),
                        Card::create(CardRank::KING, CardSuit::SPADES),
                        Card::create(CardRank::KING, CardSuit::HEARTS),
                    ],
                    'pair' => [
                        Card::create(CardRank::ACE, CardSuit::HEARTS),
                        Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    ],
                ],
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                ],
                [
                    'threeCards' => [],
                    'pair' => [],
                ],
            ],
        ];
    }

    public static function canGetFullHouseCardsRanksProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                ],
                [
                    'threeCardsRank' => CardRank::KING,
                    'pairRank' => CardRank::TEN,
                ],
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
                [
                    'threeCards' => CardRank::KING,
                    'pair' => CardRank::ACE,
                ],
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
                [
                    'threeCards' => CardRank::KING,
                    'pair' => CardRank::ACE,
                ],
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                ],
                [
                    'threeCards' => null,
                    'pair' => null,
                ],
            ],
        ];
    }
}
