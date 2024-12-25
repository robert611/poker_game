<?php

declare(strict_types=1);

namespace App\Model\Domain;

class Card
{
    private string $name;
    private CardRank $rank;
    private CardSuit $suit;

    public function getName(): string
    {
        return $this->name;
    }

    public function getRank(): CardRank
    {
        return $this->rank;
    }

    public function getSuit(): CardSuit
    {
        return $this->suit;
    }

    public static function create(CardRank $rank, CardSuit $suit): self
    {
        $card = new self();
        $card->name = self::buildName($rank, $suit);
        $card->rank = $rank;
        $card->suit = $suit;

        return $card;
    }

    public static function buildName(CardRank $rank, CardSuit $suit): string
    {
        return $rank->translate() . ' ' . $suit->translateToSingular();
    }

    /**
     * @param Card[] $cards
     *
     * @return Card[]
     */
    public static function sortCardsFromLowest(array $cards): array
    {
        // Original array given in an argument will not be sorted as it's clone not the pointer is passed

        usort($cards, fn(Card $a, Card $b) => $a->getRank()->getStrength() <=> $b->getRank()->getStrength());

        return $cards;
    }

    /**
     * Purpose of the function is to find all the cards that have pairs
     * For instance two aces and two jacks would return an array comprised of an ace and a jack
     * in ascending order
     *
     * @param Card[] $cards
     *
     * @return CardRank[]
     */
    public static function getPairsCardsRanks(array $cards): array
    {
        $pairsCards = [];

        $cards = self::sortCardsFromLowest($cards);

        foreach ($cards as $key => $card) {
            if (false === isset($cards[$key + 1])) {
                break;
            }

            $nextCard = $cards[$key + 1];

            if ($card->getRank() === $nextCard->getRank()) {
                $lastAddedRank = count($pairsCards) > 0 ? $pairsCards[count($pairsCards) - 1] : null;

                if ($lastAddedRank !== $card->getRank()) {
                    $pairsCards[] = $card->getRank();
                }
            }
        }

        return $pairsCards;
    }

    public function getThreeOfAKindCardsRank(): CardRank
    {
        // Pytanie czy nie mogę reużyć funkcji Hand::isRecognizedThreeOfAKind
        // Ona zasadniczo wykrywa trójki i wie jakie karty je tworzą ale później inaczej manipuluje taki wynik
        // Może trzeba stworzyć w folderze Model\Domain klasy dla każdego układu i tam trzymać funkcje, które obecnie
        // trzymam w Card.php i Hand.php
        // Wymagałoby to ich przeniesienia oraz przeniesienia testów
        // Pytanie czy warto to tak zrobić?
    }

    public static function isOfTheSameSuit(Card $a, Card $b): bool
    {
        if ($a->getSuit() === $b->getSuit()) {
            return true;
        }

        return false;
    }
}
