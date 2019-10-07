<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json(
            [
                'data' =>
                    [
                        0 => [
                            'name' => 'Teste',
                            'value' => 1200,
                            'date' => 1570406645,
                            'is_entrance' => false
                        ]
                    ],
                'success' => true
            ]
        );
    }
}
