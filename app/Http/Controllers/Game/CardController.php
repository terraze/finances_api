<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardController extends Controller
{
    public function index()
    {
        return response()->json(
            [
                'data' =>
                    [
                        'total_cards' => 0
                    ],
                'success' => true
            ]
        );
    }
}
