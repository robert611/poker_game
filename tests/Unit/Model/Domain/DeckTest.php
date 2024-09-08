<?php

namespace App\Tests\Unit\Model\Domain;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Deck;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DeckTest extends TestCase
{
    #[Test]
    public function canPopCard(): void
    {
        $firstCard = Card::create(CardRank::TWO, CardSuit::CLUBS);
        $secondCard = Card::create(CardRank::ACE, CardSuit::DIAMONDS);

        $deck = Deck::createDeck();
        $deck->replaceCards([$firstCard, $secondCard]);

        self::assertSame($secondCard, $deck->popCard()); // Second card is last added, so should be popped first
        self::assertSame($firstCard, $deck->popCard());
    }

    #[Test]
    public function canCreateDeck(): void
    {
        $deck = Deck::createDeck();

        self::assertCount(52, $deck->getCards());
        self::assertInstanceOf(Card::class, $deck->getCards()[0]);
        self::assertTrue($deck->isInitialDeckValid());
    }

    #[Test]
    public function canShuffleCards(): void
    {
        $deck = Deck::createDeck();

        $deck->shuffleCards();

        self::assertCount(52, $deck->getCards());
    }
}
