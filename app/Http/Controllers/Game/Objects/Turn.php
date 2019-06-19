<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 13:42
 */

namespace App\Http\Controllers\Game\Objects;

use App\Http\Controllers\Game\BaseObjects\Step;

class Turn implements Step
{

    private $currentStep = 0;

    private const STEP_TURN_START = 1;
    private const STEP_BEFORE_CARD_DRAW = 2;
    private const STEP_CARD_DRAW = 3;
    private const STEP_ACTIONS = 4;
    private const STEP_TURN_FINISH = 5;

    public function init()
    {

    }

    public function getCurrentStep()
    {
        return $this->currentStep;
    }

    public function nextStep()
    {
        $maxStep = 5;
        $this->currentStep++;
        if($this->currentStep > $maxStep){
            $this->currentStep = 0;
        }
        return $this->currentStep;
    }
}