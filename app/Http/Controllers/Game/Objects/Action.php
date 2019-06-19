<?php
/**
 * Created by PhpStorm.
 * User: TerraZe Tecnologia
 * Date: 18/06/2019
 * Time: 13:48
 */

namespace App\Http\Controllers\Game\Objects;


class Action
{
    private const STEP_EXECUTE_COMMAND = 1;
    private const STEP_CONSUME_RESOURCES = 2;
    private const STEP_RUN = 3;
    private const STEP_FINISH = 4;

}