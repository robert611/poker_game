<?php

namespace App\Tests\Unit\Model;

use App\Model\Domain\Card;
use App\Model\Domain\CardRank;
use App\Model\Domain\CardSuit;
use App\Model\Domain\Hand;
use App\Model\UserResult;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UserResultTest extends TestCase
{
    #[test]
    public function canCreate(): void
    {
        // given
        $userId = 10;
        $cards = [
            Card::create(CardRank::ACE, CardSuit::CLUBS),
            Card::create(CardRank::KING, CardSuit::SPADES),
        ];
        $place = 2;
        $hand = Hand::HIGHEST_CARD;

        // when
        $result = UserResult::create($userId, $cards, $place, $hand);

        // then
        self::assertInstanceOf(UserResult::class, $result);
        self::assertEquals($userId, $result->getUserId());
        self::assertEquals($cards, $result->getCards());
        self::assertEquals($place, $result->getPlace());
        self::assertEquals($hand, $result->getHand());
    }
}
