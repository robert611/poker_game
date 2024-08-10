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
        self::assertEquals(2, $gameResult->getUserResults()[0]->getUserId());
        self::assertEquals(3, $gameResult->getUserResults()[1]->getUserId());
        self::assertEquals(1, $gameResult->getUserResults()[2]->getUserId());
    }
}
