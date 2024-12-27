<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Domain\Hand\HandRecognition;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand\ThreeOfAKind;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ThreeOfAKindRecognitionTest extends TestCase
{
    #[Test]
    #[DataProvider('threeOfAKindProvider')]
    public function canRecognizeThreeOfAKind(array $cards, bool $expectedResult): void
    {
        $result = ThreeOfAKind::isRecognizedThreeOfAKind($cards);

        self::assertSame($expectedResult, $result);
    }

    public static function threeOfAKindProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::FIVE, CardSuit::SPADES),
                    Card::create(CardRank::FIVE, CardSuit::CLUBS),
                    Card::create(CardRank::SEVEN, CardSuit::HEARTS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                ],
                true,
            ],
            [
                [
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::FOUR, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                true,
            ],
        ];
    }
}
