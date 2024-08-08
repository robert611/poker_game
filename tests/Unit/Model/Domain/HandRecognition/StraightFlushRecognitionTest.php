<?php

namespace App\Tests\Unit\Model\Domain\HandRecognition;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use PHPUnit\Framework\TestCase;

class StraightFlushRecognitionTest extends TestCase
{
    /**
     * @test
     * @dataProvider straightFlushProvider
     */
    public function canRecognizeStraightFlush(array $cards, bool $expectedResult): void
    {
        $result = Hand::isRecognizedStraightFlush($cards);

        self::assertSame($expectedResult, $result);
    }

    public function straightFlushProvider(): array
    {
        return [
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::DIAMONDS),
                    Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                    Card::create(CardRank::SEVEN, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                true,
            ],
            [
                [
                    Card::create(CardRank::TEN, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::CLUBS),
                    Card::create(CardRank::EIGHT, CardSuit::HEARTS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::TWO, CardSuit::CLUBS),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::TWO, CardSuit::HEARTS),
                    Card::create(CardRank::SIX, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::EIGHT, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                    Card::create(CardRank::ACE, CardSuit::SPADES),
                    Card::create(CardRank::KING, CardSuit::SPADES),
                ],
                false,
            ],
            [
                [
                    Card::create(CardRank::FIVE, CardSuit::HEARTS),
                    Card::create(CardRank::EIGHT, CardSuit::SPADES),
                    Card::create(CardRank::ACE, CardSuit::DIAMONDS),
                    Card::create(CardRank::NINE, CardSuit::SPADES),
                    Card::create(CardRank::TEN, CardSuit::SPADES),
                    Card::create(CardRank::JACK, CardSuit::SPADES),
                    Card::create(CardRank::QUEEN, CardSuit::SPADES),
                ],
                true,
            ],
        ];
    }
}
