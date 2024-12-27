<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

interface HandComparisonInterface
{
    public const FIRST_PLAYER_WINS = 1;
    public const DRAW = 0;
    public const SECOND_PLAYER_WINS = -1;

    /**
     * Compares with each other two hands of the same type, for instance two hands of Highest Card
     * Function returns int
     * -1 if $firstPlayerCards are weaker than $secondPlayerCards
     *  0 if they are equal
     *  1 if $firstPlayerCards are stronger than $secondPlayerCards
     */
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int;
}