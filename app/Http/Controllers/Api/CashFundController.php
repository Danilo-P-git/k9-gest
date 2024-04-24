<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CashFund;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CashFundController extends Controller
{
    public function index()
    {
        $cash_funds = CashFund::all();
        return response()->json($cash_funds);
    }
    public function store(Request $request)
    {
        $user_id = $request->user_id;

        $amount = $request->amount;
        try {
            $cash_fund = CashFund::where('user_id', $user_id)->firstOrFail();
            if ($cash_fund) {
                $cash_fund->amount = $amount;
                $cash_fund->save();
                return response()->json($cash_fund);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function calculate(Request $request)
    {
        switch ($request->type) {
            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'weekly':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'custom':
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                break;
        }
        $transactionIncomeQuery = Transaction::with('user')->whereBetween('transaction_date', [$startDate, $endDate])->where('transaction_type', 'income');
        $transactionIncome = $transactionIncomeQuery->sum('quote');
        $transactionExpenditureQuery = Transaction::with('user')->whereBetween('transaction_date', [$startDate, $endDate])->where('transaction_type', 'expenditure');
        $transactionExpenditure = $transactionExpenditureQuery->sum('quote');
        $transactionIncomeForUser = $transactionIncomeQuery->select('user_id', DB::raw('SUM(quote) as total'))
            ->groupBy('user_id')->get();
        $transactionExpenditureForUser = $transactionExpenditureQuery->select('user_id', DB::raw('SUM(quote) as total'))
            ->groupBy('user_id')->get();
        $cash_fundQ = CashFund::with('user');
        $cashFund = $cash_fundQ->select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->get();
        $totalIncome = $transactionIncome - $transactionExpenditure;
        $transactionIncomeData = [
            'total' => $transactionIncome,
            'income_for_user' => $transactionIncomeForUser,
        ];
        $transactionExpenditureData = [
            'total' => $transactionExpenditure,
            'expenditure_for_user' => $transactionExpenditureForUser,
        ];
        return response()->json(['totalIncome' => $totalIncome, 'transactionIncome' => $transactionIncomeData, 'transactionExpenditure' => $transactionExpenditureData, 'cash_fund' => $cashFund]);
    }
}
