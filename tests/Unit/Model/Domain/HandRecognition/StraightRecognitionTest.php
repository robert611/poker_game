<?php

namespace App\Tests\Unit\Model\Domain\HandRecognition;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StraightRecognitionTest extends TestCase
{
    #[Test]
    #[DataProvider('straightProvider')]
    public function canRecognizeStraight(array $cards, bool $expectedResult): void
    {
        $result = Hand::isRecognizedStraight($cards);

        self::assertSame($expectedResult, $result);
    }

    public static function straightProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::SEVEN, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                ],
                true,
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::SPADES),
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
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
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::SPADES),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
                true,
            ],
        ];
    }
}
