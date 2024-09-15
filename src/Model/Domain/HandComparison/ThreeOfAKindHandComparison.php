<?php

declare(strict_types=1);

namespace App\Model\Domain\HandComparison;

class ThreeOfAKindHandComparison implements HandComparisonInterface
{
    public static function compare(array $firstPlayerCards, array $secondPlayerCards): int
    {
        // Zgodnie z założeniami, najpierw porównuje trzy karty składające się na trójkę, większa wygrywa
        // Jeśli trójki są takie same to porównuje "kickers" czyli pozostałe karty, musze je posegregować od największej do najmniejzej
        // Bo zaczynam porównywać od największej i aż któraś wygra.

        // Czyli najpierw rozdziel trójkę i pozostałe karty.

        return 0;
    }
}
