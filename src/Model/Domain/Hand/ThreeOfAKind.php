<?php

declare(strict_types=1);

namespace App\Model\Domain\Hand;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;

class ThreeOfAKind
{
    /**
     * @param Card[] $cards
     * @return array<int, Card[]>
     */
    public static function getRanksWithTheirCards(array $cards): array
    {
        $ranksCards = [
            CardRank::ACE->value => [],
            CardRank::KING->value => [],
            CardRank::QUEEN->value => [],
            CardRank::JACK->value => [],
            CardRank::TEN->value => [],
            CardRank::NINE->value => [],
            CardRank::EIGHT->value => [],
            CardRank::SEVEN->value => [],
            CardRank::SIX->value => [],
            CardRank::FIVE->value => [],
            CardRank::FOUR->value => [],
            CardRank::THREE->value => [],
            CardRank::TWO->value => [],
        ];

        foreach ($cards as $card) {
            $ranksCards[$card->getRank()->value][] = $card;
        }

        return $ranksCards;
    }

    /**
     * @param Card[] $cards
     */
    public static function isRecognizedThreeOfAKind(array $cards): bool
    {
        $ranksCards = self::getRanksWithTheirCards($cards);

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) === 3) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Card[] $cards
     */
    public static function getThreeOfAKindCardsRank(array $cards): ?CardRank
    {
        $ranksCards = self::getRanksWithTheirCards($cards);

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) === 3) {
                return $rankCards[array_key_first($rankCards)]->getRank();
            }
        }

        return null;
    }

    /**
     * @param Card[] $cards
     * @return Card[]
     */
    public static function getLeftOverCards(array $cards): array
    {
        $ranksCards = self::getRanksWithTheirCards($cards);

        $leftOverCards = [];

        /** @var Card[] $rankCards */
        foreach ($ranksCards as $rankCards) {
            if (count($rankCards) !== 3) {
                $leftOverCards = array_merge($leftOverCards, $rankCards);
            }
        }

        $result = [];

        // Keep the original cards order in result array
        foreach ($cards as $card) {
            foreach ($leftOverCards as $leftOverCard) {
                if ($card === $leftOverCard) {
                    $result[] = $leftOverCard;
                }
            }
        }

        return $result;
    }
}
