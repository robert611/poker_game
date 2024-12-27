<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    /**
     * @param Card[] $cards
     * @param Card[] $sortedCards
     */
    #[DataProvider('sortCardsFromLowestProvider')]
    public function testSortCardsFromLowest(array $cards, array $sortedCards): void
    {
        self::assertEquals($sortedCards, Card::sortCardsFromLowest($cards));
    }

    /**
     * @param Card[] $cards
     * @param Card[] $sortedCards
     */
    #[DataProvider('sortCardsFromHighestProvider')]
    public function testSortCardsFromHighest(array $cards, array $sortedCards): void
    {
        self::assertEquals($sortedCards, Card::sortCardsFromTheHighest($cards));
    }


    public static function sortCardsFromLowestProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                ],
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                ],
            ],
            [
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                ],
            ],
        ];
    }

    public static function sortCardsFromHighestProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                ],
            ],
            [
                [
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                ],
            ],
        ];
    }
}
