<?php

namespace App\Tests\Unit\Model\Domain\HandComparison;

use App\Model\Domain\Hand;
use PHPUnit\Framework\TestCase;

class DifferentHandsComparisonTest extends TestCase
{
    /**
     * @test
     * @dataProvider casesProvider
     */
    public function canCompareDifferentHands(Hand $firstCard, Hand $secondHard, int $expectedResult): void
    {
        $result = Hand::compareHands($firstCard, [], $secondHard, []);

        self::assertSame($expectedResult, $result);
    }

    public function casesProvider(): array
    {
        return [
            [
                Hand::FLUSH,
                Hand::ROYAL_FLUSH,
                -1,
            ],
            [
                Hand::TWO_PAIRS,
                Hand::TWO_PAIRS,
                0,
            ],
            [
                Hand::THREE_OF_A_KIND,
                Hand::TWO_PAIRS,
                1,
            ],
        ];
    }
}
