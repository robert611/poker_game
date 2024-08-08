<?php

declare(strict_types=1);

namespace App\Model\Domain;

class Deck
{
    public const DECK_INITIAL_SIZE = 52;

    /**
     * @var Card[]
     */
    private array $cards = [];

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Removes and returns the object from the end of the array
     */
    public function popCard(): Card
    {
        return array_pop($this->cards);
    }

    /**
     * @param Card[] $cards
     *
     * For testing purposes
     */
    public function replaceCards(array $cards): void
    {
        $this->cards = $cards;
    }

    public function shuffleCards(): void
    {
        shuffle($this->cards); // Uses Fisher-Yates algorithm
    }

    public function last(): ?Card
    {
        $lastKey = array_key_last($this->cards);

        if (null === $lastKey) {
            return null;
        }

        return $this->cards[$lastKey];
    }

    public static function createDeck(): Deck
    {
        $deck = new self();
        $deck->cards = self::createCards();
        $deck->shuffleCards();

        return $deck;
    }

    /**
     * @return Card[]
     */
    private static function createCards(): array
    {
        $cards = [];

        foreach (CardSuit::cases() as $cardSuit) {
            foreach (CardRank::cases() as $cardRank) {
                $cards[] = Card::create($cardRank, $cardSuit);
            }
        }

        return $cards;
    }

    public function isInitialDeckValid(): bool
    {
        // Initial deck is valid if it has 52 different cards
        $cardNames = array_map(fn ($card) => $card->getName(), $this->cards);

        return count(array_unique($cardNames)) === self::DECK_INITIAL_SIZE;
    }
}
