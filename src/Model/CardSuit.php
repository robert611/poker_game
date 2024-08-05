<?php

namespace App\Model;

enum CardSuit: string
{
    case HEARTS = 'HEARTS';
    case DIAMONDS = 'DIAMONDS';
    case CLUBS = 'CLUBS';
    case SPADES = 'SPADES';

    public function translateToSingular(): string
    {
        return match ($this) {
            self::HEARTS => 'Kier',
            self::DIAMONDS => 'Karo',
            self::CLUBS => 'Trefl',
            self::SPADES => 'Pik',
        };
    }
}
