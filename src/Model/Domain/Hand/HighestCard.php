<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;

class HighestCard
{
    /**
     * @param Card[] $cards
     */
    public static function getHighestCard(array $cards): ?Card
    {
        if (empty($cards)) {
            return null;
        }

        $highestCard = null;

        foreach ($cards as $card) {
            if (null === $highestCard) {
                $highestCard = $card;
                continue;
            }

            if ($card->getRank()->getStrength() > $highestCard->getRank()->getStrength()) {
                $highestCard = $card;
            }
        }

        return $highestCard;
    }
}
