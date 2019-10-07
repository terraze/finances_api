<?php

Route::get('/', function () {
    return response()->json(
        [
            'data' =>
            [
                'message' => "Welcome to Terra Finance API"
            ],
            'success' => true
        ]
    );
});

Route::resource('transaction', 'TransactionController');
Route::resource('bill', 'BillController');
