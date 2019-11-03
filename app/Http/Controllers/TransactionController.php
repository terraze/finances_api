<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $debug = false;

        $result = [];
        $query = Transaction::query();

        $query->orderBy('is_entrance', 'desc')
            ->orderBy('is_salary', 'desc')
            ->orderByRaw('CASE WHEN paid_date > 0 THEN 0 ELSE 1 END')
            ->orderBy('paid_date')
            ->orderBy('date');

        $account_id = (int)$request->input('account');
        if($account_id > 0){
            $query->where('account_id',$account_id);
        }

        $startDate = (int)$request->input('startDate');
        if($startDate > 0){
            $query->where('date', '>=', $startDate);
        }

        $endDate = (int)$request->input('endDate');
        if($endDate > 0){
            $query->where('date', '<=', $endDate);
        }

        if($debug) {
            DB::enableQueryLog();
            $query->get();
            dd(DB::getQueryLog());
            die;
        }

        $transactions = $query->get();

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
         * 4) Delete via React
         * 6) Load CSV
         */

        return response()->json(
            [
                'data' => $result,
                'success' => true
            ]
        );
    }

    public function store(Request $request){
        $content = json_decode($request->getContent());
        $result = [];

        foreach($content->data as $input){
            $id = (int)$input->id;
            if($id){
                $transaction = Transaction::find($id);
                if(!$transaction){
                    $result['errors']['not found'][] = $id;
                    continue;
                }
                if(isset($input->delete) && $input->delete){
                    $transaction->delete();
                    $result['deleted'][] = $id;
                    continue;
                }
            } else {
                $transaction = new Transaction();
            }

            $transaction->account_id = (int)$input->account;
            $transaction->name = $input->name;
            $transaction->is_entrance = $input->is_entrance;
            $transaction->value = $input->value;
            if($input->is_entrance){
                if(isset($input->is_salary) && $input->is_salary){
                    $transaction->is_salary = $input->is_salary;
                    $transaction->dollar = $input->dolar;
                    $transaction->worked_hours = $input->worked_hours;
                    $transaction->value = env('app.dollars_per_hour') * $input->dolar * $input->worked_hours;
                }
            } else {
                $transaction->is_salary = false;
            }

            $transaction->date = $input->date;
            $transaction->paid_date = (int)$input->paid_date;
            if(isset($input->bill_id) && (int)$input->bill_id) {
                $transaction->bill_id = (int)$input->bill_id;
            }
            $transaction->save();
            if($id){
                $result['updated'][] = $transaction->id;
            } else {
                $result['inserted'][] = $transaction->id;
            }
        }


        return response()->json(
            [
                'data' => $result,
                'success' => true
            ]
        );
    }
}
