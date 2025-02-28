<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $debug = false;
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $nextMonth = Carbon::now()->addMonth()->month;

        $result = [];
        $query = Transaction::query();

        $query
            ->orderByRaw('CASE WHEN bill_id IS NULL THEN 1 ELSE 0 END')
            ->orderBy('is_entrance', 'desc')
            ->orderByRaw('CASE WHEN paid_date > 0 THEN 0 ELSE 1 END')
            ->orderBy('paid_date')
            ->orderBy('date');

        $account_id = (int)$request->input('account');
        if($account_id > 0){
            $query->where('account_id',$account_id);
        }

        $startDate = $this->getDate($request->input('startDate'));
        if($startDate > 0){
            $query->where(function($q) use ($startDate){
                $q->where(function($q2) use ($startDate){
                    $q2->where('paid_date', '=', 0)
                        ->where('date', '>=', $startDate);
                })
                    ->orWhere('paid_date', '>=', $startDate);
            });
            $year = Carbon::createFromTimestamp($startDate)->year;
            $month = Carbon::createFromTimestamp($startDate)->month;
            $nextMonth = Carbon::createFromTimestamp($startDate)->addMonth()->month;
        }

        $endDate = $this->getDate($request->input('endDate'));
        if($endDate > 0){
            $query->where(function($q) use ($endDate){
                $q->where(function($q2) use ($endDate){
                    $q2->where('paid_date', '=', 0)
                        ->where('date', '<=', $endDate);
                })
                    ->orWhere('paid_date', '<=', $endDate);
            });
        }

        if($debug) {
            DB::enableQueryLog();
            $query->get();
            dd(DB::getQueryLog());
            die;
        }

        $bills = $this->getBills($account_id, $year, $month);
        $billsNextMonth = $this->getBills($account_id, $year, $nextMonth);

        // TODO: bills devem vir no meio entre PAGAS e EXTRAS

        $transactions = $query->get();

        foreach($transactions as $transaction){
            $item = [];
            $item['id'] = $transaction->id;
            $item['name'] = $transaction->name;
            $item['is_entrance'] = $transaction->is_entrance;

            if((!$transaction->is_entrance && $transaction->value > 0) || ($transaction->is_entrance && $transaction->value < 0)){
                $transaction->value = $transaction->value*(-1);
            }

            $item['value'] = $transaction->value;

            // Ajuste para garantir data correta independente de timezone
            $item['date'] = Carbon::createFromTimestamp($transaction->date)->timestamp;
            if($transaction->paid_date > 0) {
                $item['paid_date'] = Carbon::createFromTimestamp($transaction->paid_date)->timestamp;
            } else {
                $item['paid_date'] = $transaction->paid_date;
            }
            $item['account_id'] = $transaction->account_id;
            $item['bill_id'] = $transaction->bill_id;
            $item['is_fixed'] = false;
            if($this->isBillPaid($bills, $transaction)){
                unset($bills[$transaction->name]);
                $item['is_fixed'] = true;
            }
            if($this->isBillPaid($billsNextMonth, $transaction)){
                unset($billsNextMonth[$transaction->name]);
                $item['is_fixed'] = true;
            }

            // Exceções temporárias para transações semanais
            if (
                $transaction->name == "Salário Semanal" ||
                $transaction->name == "Cartões Pessoais" ||
                $transaction->name == "Acupuntura" ||
                $transaction->name == "Conta-Corrente" ||
                $transaction->name == "Poupança" ||
                $transaction->name == "Faxina" ||
                $transaction->name == "Psicanalista"
            ) {
                $item['is_fixed'] = true;
            }
            $result[] = $item;
        }

        foreach($bills as $bill){
            $result[] = $bill;
        }

        // Para a última semana:
        foreach($billsNextMonth as $bill){
            $result[] = $bill;
        }

        return response()->json(
            [
                'data' => $result,
                'success' => true
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

            $transaction->date = $this->getDate($input->date);
            $transaction->paid_date = $this->getDate($input->paid_date);

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

    /**
     * @param $account_id
     * @param $year
     * @param $month
     * @return array
     */
    private function getBills($account_id, $year, $month)
    {
        $result = [];
        $query = Bill::query();
        $query->select('bill.id', 'bill.name', 'bill.value', 'bill.day', DB ::raw('MONTH(from_unixtime(transaction.date)) as paid_month'));
        $query->where('bill.account_id',$account_id);
        $query->leftJoin('transaction', 'bill.id', '=', 'transaction.bill_id');
        $bills = $query->get();
        foreach($bills as $bill){
            if($bill['paid_month'] && $bill['paid_month'] == $month){
                continue;
            }
            $item = [];
            $item['id'] = null;
            $item['name'] = $bill->name;
            $item['value'] = $bill->value*(-1);

            $item['is_entrance'] = false;
            $item['is_salary'] = false;

            $day = $bill->day;

            $item['date'] = Carbon::create($year,$month,$day, 0, 0, 0, 'America/Sao_Paulo')->timestamp;
            $item['paid_date'] = null;
            $item['account_id'] = $account_id;
            $item['bill_id'] = $bill->id;
            $item['is_fixed'] = true;
            $result[$bill->name] = $item;
        }
        return $result;
    }

    /**
     * @param $bills
     * @param $name
     * @return bool
     */
    private function isBillPaid($bills, $transaction)
    {
        if(isset($bills[$transaction->name])){
            $transactionMonth = Carbon::createFromTimestamp($transaction->date)->month;
            $billMonth = Carbon::createFromTimestamp($bills[$transaction->name]['date'])->month;
            if($transactionMonth == $billMonth){
                return true;
            }
        }
        return false;
    }

    // TODO move to a middleware?
    private function getDate($date)
    {
        if(!$date){
            return 0;
        }
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);
        $date = Carbon::create($year, $month, $day, 12, 0);
        return $date->timestamp;
    }
}
