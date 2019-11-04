<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $result = [];
        $query = Bill::query();
        $query->orderBy('day', 'asc');
        $bills = $query->get();

        foreach($bills as $bill){
            $item = [];
            $item['id'] = $bill->id;
            $item['name'] = $bill->name;
            $item['value'] = $bill->value;
            $item['day'] = $bill->day;
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
