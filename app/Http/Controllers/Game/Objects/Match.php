<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 22:22
 */

namespace App\Http\Controllers\Game\Objects;


class Match
{
    /**
     * @var Game
     */
    private $game;

    public function __construct($game)
    {
        $this->game = $game;
    }
}