<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $result = [];
        $accounts = Account::all();
        foreach($accounts as $account){
            $item = [];
            $item['id'] = $account->id;
            $item['name'] = $account->name;
            $item['title'] = $account->title;
            $item['sorting'] = $account->sorting;
            $item['bank'] = $account->bank;
            $result[] = $item;
        }

        return response()->json(
            [
                'data' => $result,
                'success' => true
            ]
        );
    }
}
