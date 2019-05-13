<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        return response()->json(
            [
                'data' =>
                    [
                        'game' => "WarTech Cardgame",
                        'version' => config('app.version'),
                        'creator' => "José Ricardo Terra",
                        'creator_email' => "josericardojunior@gmail.com",
                    ],
                'success' => true
            ]
        );
    }
}
