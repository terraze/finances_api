<?php

namespace App\Http\Controllers;

use App\Import;

class ImportController extends Controller
{
    public function index()
    {
        $result = [];

        die("ja importei");

        (new Import)->import(storage_path('app/public/import/transactions/1.csv'));

        return response()->json(
            [
                'data' => $result,
                'success' => true
            ]
        );
    }
}
