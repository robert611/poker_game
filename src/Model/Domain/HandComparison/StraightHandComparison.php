<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

class StraightHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        return self::DRAW;
    }
}
