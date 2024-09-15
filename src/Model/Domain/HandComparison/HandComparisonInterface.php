<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

interface HandComparisonInterface
{
    /**
     * Compares with each other two hands of the same type, for instance two hands of Highest Card
     * Function returns int
     * -1 if $firstPlayerCards are weaker than $secondPlayerCards
     *  0 if they are equal
     *  1 if $firstPlayerCards are stronger than $secondPlayerCards
     */
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int;
}