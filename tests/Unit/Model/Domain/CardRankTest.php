<?php

namespace App\Tests\Unit\Model\Domain;

use App\Model\Domain\CardRank;
use PHPUnit\Framework\TestCase;

class CardRankTest extends TestCase
{
    /**
     * @test
     * @dataProvider rankDataProvider
     */
    public function canValidateIfRankIsOneBigger(CardRank $firstRank, CardRank $secondRank, bool $expectedResult): void
    {
        $actualResult = CardRank::isRankOneBigger($firstRank, $secondRank);
        $this->assertSame($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function canSortRanksFromBiggest(): void
    {
        // given
        $ranks = [
            CardRank::NINE,
            CardRank::ACE,
            CardRank::FOUR,
            CardRank::SIX,
            CardRank::JACK,
        ];

        // when
        $sortedRanks = CardRank::sortRanksFromBiggest($ranks);

        // then
        self::assertSame(CardRank::ACE, $sortedRanks[0]);
        self::assertSame(CardRank::JACK, $sortedRanks[1]);
        self::assertSame(CardRank::NINE, $sortedRanks[2]);
        self::assertSame(CardRank::SIX, $sortedRanks[3]);
        self::assertSame(CardRank::FOUR, $sortedRanks[4]);
    }

    public function rankDataProvider(): array
    {
        return [
            [CardRank::KING, CardRank::ACE, true],
            [CardRank::NINE, CardRank::TEN, true],
            [CardRank::THREE, CardRank::FOUR, true],
            [CardRank::FOUR, CardRank::ACE, false],
            [CardRank::JACK, CardRank::KING, false],
        ];
    }
}
