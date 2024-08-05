<?php

namespace App\Tests\Unit\Model;

use App\Model\CardRank;
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
