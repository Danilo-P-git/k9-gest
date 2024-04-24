<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(TransactionRequest $request)
    {
        $transactions = Transaction::with('user', 'category')
            ->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        if ($request->type != null) {
            $transactions = $transactions->where('transaction_type', $request->type);
        }


        if ($request->categories != null) {
            $categories = explode(',', $request->categories);
            $transactions = $transactions->whereIn('category_id', $categories);
        }

        $transactions = $transactions->orderBy($request->sort, $request->order)->paginate();
        return response()->json($transactions);
    }
    public function store(Request $request)
    {
        $transaction_date = $request->transaction_date;
        $transaction_formatted = new Carbon($transaction_date);
        $transaction = new Transaction();
        $transaction->transaction_date = $transaction_formatted;
        $transaction->quote = $request->quote;
        $transaction->category_id = $request->category_id;
        $transaction->user_id = $request->user_id;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->note = $request->note;
        $transaction->save();
        return response()->json($transaction);
    }
    public function show($id)
    {
    }
    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return response()->json($transaction);
    }
}
