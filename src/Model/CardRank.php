<?php

namespace App\Model;

enum CardRank: string
{
    case ACE = 'ACE';
    case KING = 'KING';
    case QUEEN = 'QUEEN';
    case JACK = 'JACK';
    case TEN = 'TEN';
    case NINE = 'NINE';
    case EIGHT = 'EIGHT';
    case SEVEN = 'SEVEN';
    case SIX = 'SIX';
    case FIVE = 'FIVE';
    case FOUR = 'FOUR';
    case THREE = 'THREE';
    case TWO = 'TWO';

    public function getStrength(): int
    {
        return match ($this) {
            self::ACE => 14,
            self::KING => 13,
            self::QUEEN => 12,
            self::JACK => 11,
            self::TEN => 10,
            self::NINE => 9,
            self::EIGHT => 8,
            self::SEVEN => 7,
            self::SIX => 6,
            self::FIVE => 5,
            self::FOUR => 4,
            self::THREE => 3,
            self::TWO => 2,
        };
    }

    public function translate(): string
    {
        return match ($this) {
            self::ACE => 'As',
            self::KING => 'Król',
            self::QUEEN => 'Królowa',
            self::JACK => 'Walet',
            self::TEN => 'Dziesiątka',
            self::NINE => 'Dziewiątka',
            self::EIGHT => 'Ósemka',
            self::SEVEN => 'Siódemka',
            self::SIX => 'Szóstka',
            self::FIVE => 'Piątka',
            self::FOUR => 'Czwórka',
            self::THREE => 'Trójka',
            self::TWO => 'Dwójka',
        };
    }

    public static function isRankOneBigger(CardRank $firstRank, CardRank $secondRank): bool
    {
        if ($secondRank->getStrength() === $firstRank->getStrength() + 1) {
            return true;
        }

        return false;
    }
}
