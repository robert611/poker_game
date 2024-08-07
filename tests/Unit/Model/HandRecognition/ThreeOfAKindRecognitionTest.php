<?php

namespace App\Tests\Unit\Model\HandRecognition;

use App\Model\Card;
use App\Model\CardRank;
use App\Model\CardSuit;
use App\Model\Hand;
use PHPUnit\Framework\TestCase;

class ThreeOfAKindRecognitionTest extends TestCase
{
    /**
     * @test
     * @dataProvider threeOfAKindProvider
     */
    public function canRecognizeThreeOfAKind(array $cards, bool $expectedResult): void
    {
        $result = Hand::isRecognizedThreeOfAKind($cards);

        self::assertSame($expectedResult, $result);
    }

    public function threeOfAKindProvider(): array
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
