<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->latest()->get();
        return view('pages.transactions', [
            'transactions' => $transactions
        ]); 
    }

    public function details($id)
    {
        $transaction = Transaction::where('id', $id)->firstOrFail();
        return view('pages.transaction-details', [
            'transaction' => $transaction
        ]); 
    }

    public function expired($id)
    {
        $transaction = Transaction::where('id', $id)->firstOrFail();
        $transaction->update([
            'transaction_status' => 'CANCELLED',
            'resi' => 'NULL',
            'shipping_status' => 'CANCELLED'
        ]);
        foreach($transaction->transactions as $transaction)
        {
            $stock = $transaction->product->stocks->where('size_id', $transaction->size_id)->firstOrFail();
            $stock->update([
                'stock' => $stock->stock + $transaction->qty
            ]);
        }
        return redirect('/transactions');
    }
}
