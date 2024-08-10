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
        uasort($usersCards, function (UserCards $a, UserCards $b) {
            return $b->getHand()->value <=> $a->getHand()->value;
        });

        $isHandRepeated = UserCards::hasRepeatedHand($usersCards);

        if (false === $isHandRepeated) {
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

        // W tym przypadku trzeba porównać te same układy, żeby ustalić kolejność

        // Potrzebuje pętli z góry, która pozmienia miejsca w tablicy z $usersCards, oraz samej funkcji
        // compareHands w modelu Hands

        uasort($usersCards, function (UserCards $a, UserCards $b) {
            return Hand::compareHands($a->getHand(), $a->getCards(), $b->getHand(), $b->getCards());
        });

        return new GameResult();
    }
}
