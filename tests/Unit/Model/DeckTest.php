<?php

namespace App\Tests\Unit\Model;

use App\Model\Card;
use App\Model\CardRank;
use App\Model\CardSuit;
use App\Model\Deck;
use PHPUnit\Framework\TestCase;

class DeckTest extends TestCase
{
    /**
     * @test
     */
    public function canPopCard(): void
    {
        $firstCard = Card::create(CardRank::TWO, CardSuit::CLUBS);
        $secondCard = Card::create(CardRank::ACE, CardSuit::DIAMONDS);

        $deck = Deck::createDeck();
        $deck->replaceCards([$firstCard, $secondCard]);

        self::assertSame($secondCard, $deck->popCard()); // Second card is last added, so should be popped first
        self::assertSame($firstCard, $deck->popCard());
    }

    /**
     * @test
     */
    public function canCreateDeck(): void
    {
        $deck = Deck::createDeck();

        self::assertCount(52, $deck->getCards());
        self::assertInstanceOf(Card::class, $deck->getCards()[0]);
        self::assertTrue($deck->isInitialDeckValid());
    }

    /**
     * @test
     */
    public function canShuffleCards(): void
    {
        $deck = Deck::createDeck();

        $deck->shuffleCards();

        self::assertCount(52, $deck->getCards());
    }
}
