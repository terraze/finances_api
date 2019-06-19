<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 13:59
 */

namespace App\Http\Controllers\Game\BaseObjects;


interface Step
{

    /**
     * Returns the current step.
     *
     * @return integer
     */
    public function getCurrentStep();

    /**
     * Moves to next step and returns the (new) current step. Return 0 if finished.
     *
     * @return integer Moves to next
     */
    public function nextStep();
}