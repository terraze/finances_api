<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $result = [];
        $transactions = Transaction::all();
        foreach($transactions as $transaction){
            $item = [];
            $item['id'] = $transaction->id;
            $item['name'] = $transaction->name;
            $item['is_entrance'] = $transaction->is_entrance;
            $item['is_salary'] = $transaction->is_salary;
            $item['value'] = $transaction->value;
            $item['dollar'] = $transaction->dollar;
            $item['worked_hours'] = $transaction->worked_hours;
            $item['date'] = $transaction->date;
            $item['paid_date'] = $transaction->paid_date;
            $item['account_id'] = $transaction->account_id;
            $item['bill_id'] = $transaction->bill_id;
            $item['is_fixed'] = false; // TODO change
            $result[] = $item;
        }

        // TODO:
        /**
         * 1) Add test items on SQL
         * 2) Fix any issues on JS
         * 3) Insert via React
         * 4) Delete via React
         * 5) Update via React
         * 6) Load CSV
         */

        return response()->json(
            [
                'data' => $result,
                'success' => true
            ]
        );
    }
}
