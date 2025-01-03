<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand\HandRecognition;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\FullHouse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FullHouseRecognitionTest extends TestCase
{
    #[Test]
    #[DataProvider('fullHouseProvider')]
    public function canRecognizeFullHouse(array $cards, bool $expectedResult): void
    {
        $result = FullHouse::isRecognizedFullHouse($cards);

        self::assertSame($expectedResult, $result);
    }

    public static function fullHouseProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                true,
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::FOUR, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::CLUBS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
                true,
            ],
        ];
    }
}
