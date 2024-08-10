<?php

namespace App\Service;

use App\Model\Domain\Hand;
use App\Model\GameResult;
use App\Model\UserCards;
use App\Model\UserResult;

class HandComparator
{
    /**
     * @param UserCards[] $usersCards
     */
    public function compareHands(array $usersCards): GameResult
    {
        usort($usersCards, function (UserCards $a, UserCards $b) {
            return Hand::compareHands($b->getHand(), $b->getCards(), $a->getHand(), $a->getCards());
        });

        $userResults = [];

        foreach ($usersCards as $key => $userCards) {
            $userResults[] = UserResult::create(
                $userCards->getUserId(),
                $userCards->getCards(),
                $key + 1,
                $userCards->getHand(),
            );
        }

        return GameResult::create($userResults);
    }
}
