<?php

namespace App\Tests\Unit\Model\HandRecognition;

use App\Model\Card;
use App\Model\CardRank;
use App\Model\CardSuit;
use App\Model\Hand;
use PHPUnit\Framework\TestCase;

class RoyalFlushRecognitionTest extends TestCase
{
    /**
     * @test
     * @dataProvider royalFlushProvider
     */
    public function canRecognizeRoyalFLush(array $cards, bool $expectedResult): void
    {
        $result = Hand::isRecognizedRoyalFlush($cards);

        self::assertSame($expectedResult, $result);
    }

    public function royalFlushProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::QUEEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
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
                    Card::create(CardRank::QUEEN, CardSuit::CLUBS),
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::TEN, CardSuit::CLUBS),
                    Card::create(CardRank::JACK, CardSuit::CLUBS),
                    Card::create(CardRank::KING, CardSuit::CLUBS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::CLUBS),
                ],
                true,
            ],
        ];
    }
}
