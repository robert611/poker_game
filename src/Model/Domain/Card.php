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
