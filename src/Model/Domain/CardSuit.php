<?php

declare(strict_types=1);

namespace App\Model\Domain;

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
