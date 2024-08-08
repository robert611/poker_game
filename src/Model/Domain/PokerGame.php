<?php

declare(strict_types=1);

namespace App\Model\Domain;

class PokerGame
{
    public const INITIAL_DEALT_CARDS_TO_PLAYER = 2;
    public const CARDS_TO_FLOP_NUMBER = 3;

    private Deck $deck;

    /**
     * @var Card[]
     */
    private array $dealtCards = [];

    /**
     * @var Card[]
     */
    private array $floppedCards = [];

    private Card $turnCard;
    private Card $riverCard;

    public function getDeck(): Deck
    {
        return $this->deck;
    }

    /**
     * @return Card[]
     */
    public function getDealtCards(): array
    {
        return $this->dealtCards;
    }

    /**
     * @return Card[]
     */
    public function getFloppedCards(): array
    {
        return $this->floppedCards;
    }

    public function getTurnCard(): Card
    {
        return $this->turnCard;
    }

    public function getRiverCard(): Card
    {
        return $this->riverCard;
    }

    public static function create(): self
    {
        $pokerGame = new PokerGame();
        $pokerGame->deck = Deck::createDeck();

        return $pokerGame;
    }

    /**
     * Deal players two cards each from the deck to start the game
     *
     * @return Card[]
     */
    public function dealCards(int $playersCount): array
    {
        $cardsToDealNumber = $playersCount * self::INITIAL_DEALT_CARDS_TO_PLAYER;

        $dealtCards = [];

        for ($i = 0; $i < $cardsToDealNumber; $i++) {
            $dealtCards[] = $this->deck->popCard();
        }

        $this->dealtCards = $dealtCards;

        return $this->dealtCards;
    }

    /**
     * Flop three cards after players were dealt their initial cards
     *
     * @return Card[]
     */
    public function flopCards(): array
    {
        $floppedCards = [];

        for ($i = 0; $i < self::CARDS_TO_FLOP_NUMBER; $i++) {
            $floppedCards[] = $this->deck->popCard();
        }

        $this->floppedCards = $floppedCards;

        return $this->floppedCards;
    }

    public function turn(): Card
    {
        $turnCard = $this->deck->popCard();

        $this->turnCard = $turnCard;

        return $this->turnCard;
    }

    public function river(): Card
    {
        $riverCard = $this->deck->popCard();

        $this->riverCard = $riverCard;

        return $this->riverCard;
    }

    // Chcę zmodelować gre w pokera w tej klasie
    // Ona będzie mieć wszystkie podstawowe funkcje w grze, typu rozdaj kolejną kartę
    //

    // Odmiana Poker Texas Hold'em, dostajemy wszystkie 52 karty

    // Zestawy kart
    // 1. High cart (najwyższa karta)
    // 2. Pair of cards (para kart)
    // 3. Two pair of cards (dwie pary)
    // 4. Three of a kind (trójka)
    // 5. Straight (strit)
    // 6. Flush (kolor)
    // 7. Full house (full)
    // 8. Four of a kind (kareta)
    // 9. Straight flush (poker)
    // 10. Royal Flush (straight flush, od 10 do Asa)

    // Ante, to kwota wejściowa, wymagana do zapłaty, żeby zagrać przed partią

    // Dealer (rozdający to będzie komputer)

    // Każdy gracz dostaje dwie karty na początku

    // fold means poddanie się

    // check wyrównanie kwoty

    // raise dodanie kwoty

    // Po kwestii pieniężnej

    // Delaer, wyjmuje i pokazuje trzy karty, nazywa się to flop

    // Po flopie znów jest kwestia pieniężna

    // Pokazanie czwartej karty to "turn"

    // Znów kwestia pieniężna

    // Pokazanie ostatniej karty to "river"

    // Znów kwestia pieniężna

    // Więc mamy 7 kart na końcu, ten kto ma najlepszy zestaw wygrywa

    // Muszę co zrobić: stworzyć reprezentacje 52 kart, pytanie czy chcę własny obiekt pod kartę? Czy bardziej jeden,
    // obiekt karta z atrybutami
}
