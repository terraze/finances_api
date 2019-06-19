<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 13:40
 */

namespace App\Http\Controllers\Game\Objects;


abstract class Card
{
    // Type definition
    const TYPE_BASE = 0;
    const TYPE_MILITARY_UNIT = 1;
    const TYPE_MILITARY_STRUCTURE = 2;
    const TYPE_TACTICAL = 3;
    const TYPE_RESOURCE_ENERGY = 4;
    const TYPE_RESOURCE_METAL = 5;
    const TYPE_EMERGENCY = 6;

    // Tier definition
    const TIER_1 = 1;
    const TIER_2 = 2;
    const TIER_3 = 3;

    public function init()
    {

    }

    public function whereIs()
    {
        // Where the card is? Hand, battlefield or junkyard
    }

    public function canConsume()
    {
        // Check if resources are enough to consume the card
    }

    public function consume()
    {
        // Player uses/builds the card
    }

    public function getPossibleTargets()
    {
        // List of cards (enemy and ally) that can be targeted by this
    }

    public function tacticalUse()
    {
        // Called when a tactical card is used
    }

    public function build()
    {
        // Called when a structure or unit is placed on battlefield
    }

    public function destroy()
    {
        // Called when a structure or unit is removed from battlefield
    }


}