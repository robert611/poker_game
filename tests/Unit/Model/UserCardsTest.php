<?php

namespace App\Tests\Unit\Model;

use App\Model\Domain\Hand;
use App\Model\UserCards;
use PHPUnit\Framework\TestCase;

class UserCardsTest extends TestCase
{
    /**
     * @test
     */
    public function willSeeThatHandIsRepeated(): void
    {
        // given
        $userCardsFirst = UserCards::create(20, [], Hand::PAIR);
        $userCardsSecond = UserCards::create(21, [], Hand::TWO_PAIRS);
        $userCardsThird = UserCards::create(22, [], Hand::TWO_PAIRS);
        $userCardsFourth = UserCards::create(23, [], Hand::FLUSH);

        // when
        $result = UserCards::hasRepeatedHand([
            $userCardsFirst,
            $userCardsSecond,
            $userCardsThird,
            $userCardsFourth,
        ]);

        // then
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function willSeeThatHandIsNotRepeated(): void
    {
        // given
        $userCardsFirst = UserCards::create(20, [], Hand::PAIR);
        $userCardsSecond = UserCards::create(21, [], Hand::TWO_PAIRS);
        $userCardsThird = UserCards::create(22, [], Hand::FULL_HOUSE);
        $userCardsFourth = UserCards::create(23, [], Hand::FLUSH);
        $userCardsFifth = UserCards::create(24, [], Hand::ROYAL_FLUSH);

        // when
        $result = UserCards::hasRepeatedHand([
            $userCardsFirst,
            $userCardsSecond,
            $userCardsThird,
            $userCardsFourth,
            $userCardsFifth,
        ]);

        // then
        $this->assertFalse($result);
    }
}
