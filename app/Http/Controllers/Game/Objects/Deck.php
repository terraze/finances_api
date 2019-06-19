<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 22:28
 */

namespace App\Http\Controllers\Game\Objects;


class Deck
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var array Card
     */
    private $cards = [];

    /**
     * @var Base
     */
    private $base;

    public function __construct($id)
    {
        $this->id = $id;
        // Get deck from database
        // Get base card from database
        // Get cards from database
    }

    public function shuffle()
    {
        // Shuffles the deck
    }

    public function getBaseCard()
    {
        return $this->base;
    }

    public function getStartingHand()
    {
        // Shuffles the deck
    }

    public function drawCard($tier, $type, $count = 1)
    {
        // Draws $count cards of specific $tier and $type from deck
    }

    public function getCardCount()
    {
        // Number of cards in the deck, separated by tier and type, with total
    }
}