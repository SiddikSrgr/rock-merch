<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables; 
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $transaction = Transaction::with('user')->latest();

            return DataTables::of($transaction)
            ->addColumn('User', function (Transaction $transaction) {
                return $transaction->user->name;
            })
            ->editColumn('transaction_status', function ($transaction) {
                if($transaction->transaction_status == "PENDING"){
                    return '<p class="text-danger">PENDING</p>'; 
                } elseif($transaction->transaction_status == "CONFIRMED"){
                    return '<p class="text-primary">CONFIRMED</p>';
                } elseif($transaction->transaction_status == "SUCCESS"){
                    return '<p class="text-success">SUCCESS</p>';
                }
            })
            ->editColumn('shipping_status', function ($transaction) {
                if($transaction->shipping_status == "PENDING" ){
                    return '<p class="text-danger">PENDING</p>'; 
                } elseif($transaction->shipping_status == "SHIPPING"){
                    return '<p class="text-primary">SHIPPING</p>';
                } elseif($transaction->shipping_status == "SUCCESS"){
                    return '<p class="text-success">SUCCESS</p>';
                }
            })
            ->addColumn('action', function ($transaction) {
                    return '<div class="row pl-3">
                                <a class="btn btn-info btn-sm mr-1"  href="' . route('transactions.show', $transaction->id) . '"> Details</a>
                            </div>';
                }
            )
            ->rawColumns(['user', 'transaction_status', 'shipping_status', 'action'])
            ->toJson();
        }
        return view('pages.admin.transaction.index');
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('pages.admin.transaction.details', ['transaction' => $transaction]);
    }
}
