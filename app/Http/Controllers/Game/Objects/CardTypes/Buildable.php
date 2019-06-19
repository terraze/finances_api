<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 23:15
 */

namespace App\Http\Controllers\Game\Objects\CardTypes;

use App\Http\Controllers\Game\Objects\Card;

abstract class Buildable extends Card
{
    public function getArmor()
    {
        return 1;
    }

    public function getHitPoints()
    {
        return 1;
    }

    public function getEnergyProduction()
    {
        return 0;
    }

    public function getMetalProduction()
    {
        return 0;
    }
}