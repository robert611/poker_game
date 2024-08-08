<?php

namespace App\Tests\Unit\Model\Domain;

use App\Model\Domain\Card;
use App\Model\Domain\PokerGame;
use PHPUnit\Framework\TestCase;

class PokerGameTest extends TestCase
{
    /**
     * @test
     */
    public function canDealCards(): void
    {
        $pokerGame = PokerGame::create();
        $lastCardInDeck = $pokerGame->getDeck()->last();

        $playersCount = 5;

        $dealtCards = $pokerGame->dealCards($playersCount);

        self::assertSame($dealtCards, $pokerGame->getDealtCards());
        self::assertCount(10, $dealtCards);
        self::assertSame($dealtCards[0], $lastCardInDeck);
    }

    /**
     * @test
     */
    public function canFlopCards(): void
    {
        $pokerGame = PokerGame::create();
        $deckCards = $pokerGame->getDeck()->getCards();

        $floppedCards = $pokerGame->flopCards();

        self::assertSame($floppedCards, $pokerGame->getFloppedCards());
        self::assertCount(3, $floppedCards);
        self::assertSame($floppedCards[0], $deckCards[count($deckCards) - 1]);
        self::assertSame($floppedCards[1], $deckCards[count($deckCards) - 2]);
        self::assertSame($floppedCards[2], $deckCards[count($deckCards) - 3]);
    }

    /**
     * @test
     */
    public function canTurn(): void
    {
        $pokerGame = PokerGame::create();
        $lastCardInDeck = $pokerGame->getDeck()->last();

        $turnCard = $pokerGame->turn();

        self::assertSame($turnCard, $pokerGame->getTurnCard());
        self::assertSame($turnCard, $lastCardInDeck);
    }

    /**
     * @test
     */
    public function canRiver(): void
    {
        $pokerGame = PokerGame::create();
        $lastCardInDeck = $pokerGame->getDeck()->last();

        $riverCard = $pokerGame->river();

        self::assertSame($riverCard, $pokerGame->getRiverCard());
        self::assertSame($riverCard, $lastCardInDeck);
    }

    /**
     * @test
     */
    public function canGoThroughWholeGame(): void
    {
        $pokerGame = PokerGame::create();

        $playersCount = 3;

        // Execute all operation necessary to give players all seven cards
        $pokerGame->dealCards($playersCount);
        $pokerGame->flopCards();
        $pokerGame->turn();
        $pokerGame->river();

        self::assertCount(6, $pokerGame->getDealtCards());
        self::assertCount(3, $pokerGame->getFloppedCards());
        self::assertInstanceOf(Card::class, $pokerGame->getTurnCard());
        self::assertInstanceOf(Card::class, $pokerGame->getRiverCard());
    }
}
