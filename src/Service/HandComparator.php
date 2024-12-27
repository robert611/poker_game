<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Domain\Hand;
use App\Model\Domain\HandComparison\HandComparisonInterface;
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
        $draws = [];

        usort($usersCards, function (UserCards $a, UserCards $b) use (&$draws) {
            $comparison = Hand::compareHands($b->getHand(), $b->getCards(), $a->getHand(), $a->getCards());

            if (HandComparisonInterface::DRAW === $comparison) {
                $draws[] = [$a->getUserId(), $b->getUserId()];
            }

            return $comparison;
        });

        $userResults = [];
        $currentPlace = 1;

        foreach ($usersCards as $key => $userCards) {
            if (false === isset($usersCards[$key - 1])) {
                $place = 1;
            } else if (in_array([$usersCards[$key - 1]->getUserId(), $userCards->getUserId()], $draws)) {
                $place = $currentPlace;
            } else {
                $currentPlace = $key + 1;
                $place = $currentPlace;
            }

            $userResults[] = UserResult::create(
                $userCards->getUserId(),
                $userCards->getCards(),
                $place,
                $userCards->getHand(),
            );
        }

        return GameResult::create($userResults);
    }
}
