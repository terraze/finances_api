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

Route::resource('account', 'AccountController');
Route::resource('bill', 'BillController');
Route::resource('transaction', 'TransactionController');
