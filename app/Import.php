<?php

namespace App;

use App\Transaction;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class Import implements ToModel
{
    use Importable;

    /**
     * @param array $row
     *
     * @return Transaction|null
     */
    public function model(array $row)
    {
        if($row[0] == 'date' || empty($row[0])){
            return null;
        }
        $transaction = new Transaction();
        $transaction->account_id = 1;

        $transaction->date = \DateTime::createFromFormat('d-m-Y', $row[0])->getTimestamp();
        $transaction->name = $row[1];
        $transaction->value = (float)str_replace(',', ".", $row[2]);

        if($transaction->value > 0){
            $transaction->is_entrance = true;
        } else {
            $transaction->is_entrance = false;
        }
        $transaction->is_salary = false;


        $transaction->paid_date = $transaction->date;

        return $transaction;
    }
}
