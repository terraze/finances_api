<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 22:21
 */

namespace App\Http\Controllers\Game\Objects;


class Game
{
    /**
     * @var Player
     */
    private $player1;

    /**
     * @var Player
     */
    private $player2;

    /**
     * @var int
     */
    private $starter;

    /**
     * @var Match
     */
    private $match;

    public function init()
    {
        $this->getPlayers();

        // Mocked
        $deck1_id = 1;
        $deck2_id = 2;

        $this->player1->loadDeck($deck1_id);
        $this->player2->loadDeck($deck2_id);

        $this->chooseStarter();

        // Get player info like name, avatar, etc
    }

    public function getPlayers()
    {
        // Mocked
        $id1 = 1;
        $id2 = 2;

        $this->player1 = new Player($id1);
        $this->player2 = new Player($id2);
    }

    public function start()
    {
        $this->match = new Match($this);
    }

    private function chooseStarter()
    {
        $this->starter = rand(1,2);
    }
}