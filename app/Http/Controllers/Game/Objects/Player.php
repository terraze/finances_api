<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 22:25
 */

namespace App\Http\Controllers\Game\Objects;


class Player
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Deck
     */
    private $deck;

    /**
     * @var Junkyard
     */
    private $junkyard;

    /**
     * @var Base
     */
    private $base;

    /**
     * @var int
     */
    private $armor;

    /**
     * @var int
     */
    private $hitPoints;

    public function __construct($id)
    {
        $this->id = $id;
        $this->junkyard = new Junkyard();
    }

    public function loadDeck($id)
    {
        $this->deck = new Deck($id);
        $this->deck->shuffle();
        $this->base = $this->deck->getBaseCard();
    }

    public function loadHand()
    {
        $this->deck->getStartingHand();
    }

    public function getName()
    {
        if($this->id == 1){
            return "Player 1";
        }
        return "Player 2";
    }


    public function getCurrentArmor()
    {
        return $this->base->getArmor();
    }

    public function getCurrentHitPoints()
    {
        return $this->hitPoints;
    }

    public function getCurrentEnergyGeneration()
    {
        $energy = 0;
        $energy += $this->base->getEnergyProduction();
        // Calculate for all cards
        return $energy;
    }

    public function getCurrentEnergyConsumption()
    {
        $energy = 0;
        $energy += $this->base->getEnergyProduction();
        // Calculate for all cards
        return $energy;
    }

    public function getAvailableEnergy()
    {
        return $this->getCurrentEnergyGeneration() - $this->getCurrentEnergyConsumption();
    }

    public function getCurrentMetalGeneration()
    {
        $metal = 0;
        $metal += $this->base->getMetalProduction();
        // Calculate for all cards
        return $metal;
    }

    public function getAvailableMetal()
    {
        return $this->getCurrentMetalGeneration();
    }
}