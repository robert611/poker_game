<?php

namespace App\Tests\Unit\Model\Domain\HandRecognition;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FourOfAKindRecognitionTest extends TestCase
{
    #[Test]
    #[DataProvider('fourOfAKindProvider')]
    public function canRecognizeFourOfAKind(array $cards, bool $expectedResult): void
    {
        $result = Hand::isRecognizedFourOfAKind($cards);

        self::assertSame($expectedResult, $result);
    }

    public static function fourOfAKindProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
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
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::CLUBS),
                    Card::create(CardRank::SEVEN, CardSuit::SPADES),
                    Card::create(CardRank::TWO, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::CLUBS),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::KING, CardSuit::CLUBS),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::CLUBS),
                    Card::create(CardRank::KING, CardSuit::HEARTS),
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                ],
                true,
            ],
        ];
    }
}
