<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\FourOfAKind;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FourOfAKindTest extends TestCase
{
    #[Test]
    #[DataProvider('canGetFourOfAKindRankProvider')]
    public function canGetFourOfAKindRank(array $cards, CardRank $expectedRank): void
    {
        self::assertEquals($expectedRank, FourOfAKind::getFourOfAKindRank($cards));
    }

    #[Test]
    #[DataProvider('canGetLeftOverCardsProvider')]
    public function canLeftOverCards(array $cards, array $expectedCards): void
    {
        self::assertEquals($expectedCards, FourOfAKind::getLeftOverCards($cards));
    }

    public static function canGetFourOfAKindRankProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                ],
                CardRank::FOUR,
            ],
            [
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                ],
                CardRank::ACE,
            ],
        ];
    }

    /**
     * @return array<int, array<int, Card[]>>
     */
    public static function canGetLeftOverCardsProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                ],
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::CLUBS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                ],
                [
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                ],
            ],
        ];
    }
}
