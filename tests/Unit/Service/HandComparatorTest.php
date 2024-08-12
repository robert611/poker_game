<?php

namespace App\Tests\Unit\Service;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use App\Model\GameResult;
use App\Model\UserCards;
use App\Service\HandComparator;
use PHPUnit\Framework\TestCase;

class HandComparatorTest extends TestCase
{
    /**
     * @test
     */
    public function canCompareDifferentHands(): void
    {
        // given
        $firstUserCards = UserCards::create(
            1,
            [
                Card::create(CardRank::SIX, CardSuit::HEARTS),
                Card::create(CardRank::SIX, CardSuit::SPADES),
            ],
            Hand::TWO_PAIRS,
        );
        $secondUserCards = UserCards::create(
            2,
            [
                Card::create(CardRank::SIX, CardSuit::HEARTS),
                Card::create(CardRank::SIX, CardSuit::SPADES),
                Card::create(CardRank::SIX, CardSuit::DIAMONDS),
                Card::create(CardRank::SIX, CardSuit::CLUBS),
            ],
            Hand::FOUR_OF_A_KIND,
        );
        $thirdUserCards = UserCards::create(
            3,
            [
                Card::create(CardRank::SIX, CardSuit::HEARTS),
                Card::create(CardRank::SIX, CardSuit::SPADES),
                Card::create(CardRank::SIX, CardSuit::DIAMONDS),
            ],
            Hand::THREE_OF_A_KIND,
        );

        // when
        $handComparator = new HandComparator();
        $gameResult = $handComparator->compareHands([
            $firstUserCards,
            $secondUserCards,
            $thirdUserCards,
        ]);

        // then
        self::assertInstanceOf(GameResult::class, $gameResult);
        self::assertEquals(1, $gameResult->getUserResultByUserId(2)->getPlace());
        self::assertEquals(2, $gameResult->getUserResultByUserId(3)->getPlace());
        self::assertEquals(3, $gameResult->getUserResultByUserId(1)->getPlace());
    }

    /**
     * @test
     */
    public function canCompareHighestCardHands(): void
    {
        // given
        $firstUserCards = UserCards::create(
            1,
            [
                Card::create(CardRank::FIVE, CardSuit::HEARTS),
                Card::create(CardRank::FOUR, CardSuit::SPADES),
            ],
            Hand::HIGHEST_CARD,
        );
        $secondUserCards = UserCards::create(
            2,
            [
                Card::create(CardRank::THREE, CardSuit::HEARTS),
                Card::create(CardRank::QUEEN, CardSuit::SPADES),
                Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                Card::create(CardRank::NINE, CardSuit::CLUBS),
            ],
            Hand::HIGHEST_CARD,
        );
        $thirdUserCards = UserCards::create(
            3,
            [
                Card::create(CardRank::SIX, CardSuit::HEARTS),
                Card::create(CardRank::SIX, CardSuit::SPADES),
                Card::create(CardRank::TEN, CardSuit::DIAMONDS),
                Card::create(CardRank::TWO, CardSuit::CLUBS),
            ],
            Hand::HIGHEST_CARD,
        );
        $fourthUserCards = UserCards::create(
            4,
            [
                Card::create(CardRank::TWO, CardSuit::HEARTS),
            ],
            Hand::HIGHEST_CARD,
        );
        $fifthUserCards = UserCards::create(
            5,
            [
                Card::create(CardRank::NINE, CardSuit::HEARTS),
            ],
            Hand::HIGHEST_CARD,
        );

        // when
        $handComparator = new HandComparator();
        $gameResult = $handComparator->compareHands([
            $firstUserCards,
            $secondUserCards,
            $thirdUserCards,
            $fourthUserCards,
            $fifthUserCards,
        ]);

        // then
        self::assertInstanceOf(GameResult::class, $gameResult);
        self::assertEquals(1, $gameResult->getUserResultByUserId(2)->getPlace()); // Queen
        self::assertEquals(2, $gameResult->getUserResultByUserId(3)->getPlace()); // TEN
        self::assertEquals(3, $gameResult->getUserResultByUserId(5)->getPlace()); // NINE
        self::assertEquals(4, $gameResult->getUserResultByUserId(1)->getPlace()); // FIVE
        self::assertEquals(5, $gameResult->getUserResultByUserId(4)->getPlace()); // TWO
    }

    /**
     * @test
     */
    public function canRecognizeADrawBetweenHands(): void
    {
        // given
        $firstUserCards = UserCards::create(
            1,
            [
                Card::create(CardRank::FIVE, CardSuit::HEARTS),
                Card::create(CardRank::ACE, CardSuit::DIAMONDS),
            ],
            Hand::HIGHEST_CARD,
        );
        $secondUserCards = UserCards::create(
            2,
            [
                Card::create(CardRank::ACE, CardSuit::SPADES),
                Card::create(CardRank::THREE, CardSuit::DIAMONDS),
                Card::create(CardRank::NINE, CardSuit::CLUBS),
            ],
            Hand::HIGHEST_CARD,
        );
        $thirdUserCards = UserCards::create(
            3,
            [
                Card::create(CardRank::SIX, CardSuit::HEARTS),
                Card::create(CardRank::ACE, CardSuit::HEARTS),
            ],
            Hand::HIGHEST_CARD,
        );
        $fourthUserCards = UserCards::create(
            4,
            [
                Card::create(CardRank::TWO, CardSuit::HEARTS),
                Card::create(CardRank::TWO, CardSuit::SPADES),
            ],
            Hand::TWO_PAIRS,
        );
        $fifthUserCards = UserCards::create(
            5,
            [
                Card::create(CardRank::NINE, CardSuit::HEARTS),
                Card::create(CardRank::NINE, CardSuit::DIAMONDS),
                Card::create(CardRank::NINE, CardSuit::SPADES),
            ],
            Hand::THREE_OF_A_KIND,
        );

        // when
        $handComparator = new HandComparator();
        $gameResult = $handComparator->compareHands([
            $firstUserCards,
            $secondUserCards,
            $thirdUserCards,
            $fourthUserCards,
            $fifthUserCards,
        ]);

        // then
        self::assertInstanceOf(GameResult::class, $gameResult);
        self::assertEquals(1, $gameResult->getUserResultByUserId(5)->getPlace()); // Three of a kind
        self::assertEquals(2, $gameResult->getUserResultByUserId(4)->getPlace()); // Two pairs
        self::assertEquals(3, $gameResult->getUserResultByUserId(1)->getPlace()); // Highest card Ace
        self::assertEquals(3, $gameResult->getUserResultByUserId(2)->getPlace()); // Highest card Ace
        self::assertEquals(3, $gameResult->getUserResultByUserId(3)->getPlace()); // Highest card Ace
    }
}
