<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 22:34
 */

namespace App\Http\Controllers\Game\Objects;


class Junkyard
{
    private $cards = [];

    public function __construct()
    {

    }

    public function addCard($card)
    {
        $this->cards[] = $card;
    }

    public function getCountCards()
    {
        // Number of cards in the deck, separated by tier and type, with total
    }
}