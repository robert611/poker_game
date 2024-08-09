<?php

namespace App\Tests\Unit\Model\Domain\HandRecognition;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use PHPUnit\Framework\TestCase;

class FlushRecognitionTest extends TestCase
{
    /**
     * @test
     * @dataProvider flushProvider
     */
    public function canRecognizeFlush(array $cards, bool $expectedResult): void
    {
        $result = Hand::isRecognizedFlush($cards);

        self::assertSame($expectedResult, $result);
    }

    public function flushProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::JACK, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::HEARTS),
                    Card::create(CardRank::QUEEN, CardSuit::HEARTS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
                    Card::create(CardRank::SEVEN, CardSuit::HEARTS),
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
                    Card::create(CardRank::THREE, CardSuit::CLUBS),
                    Card::create(CardRank::ACE, CardSuit::HEARTS),
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
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::KING, CardSuit::DIAMONDS),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::FOUR, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                ],
                true,
            ],
        ];
    }
}