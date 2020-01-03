<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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
})->name('home');

Route::resource('login', 'Auth\LoginController');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('register', 'Auth\LoginController@register');

Route::group(['middleware' => 'auth:api'], function(){
	Route::resource('account', 'AccountController');
	Route::resource('bill', 'BillController');
	Route::resource('transaction', 'TransactionController');
	Route::resource('importer', 'ImportController');
});