<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables; 
use App\Models\Confirmation;

class ConfirmationController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $confirmation = Confirmation::with('transaction')->latest(); 

            return DataTables::of($confirmation)
            ->addColumn('code', function ($confirmation) {
                return '<a  href="' . route('transactions.show', $confirmation->transaction->id) . '">
                            '.$confirmation->transaction->code.'
                        </a>';
            })
            ->addColumn('total_price', function ($confirmation) {
                return $confirmation->transaction->total_price;
            })
            ->editColumn('photo', function ($confirmation) {
                return $confirmation->photo ? '<a href=" '.asset('storage/'. $confirmation->photo).' ">
                                                    <img src=" '.asset('storage/'. $confirmation->photo).' " style="max-height: 48px;">
                                                </a>' : '';
            })
            ->editColumn('status', function ($confirmation) {
                return $confirmation->status == 1 ? '<p class="text-success">ACCEPTED</p>' : '<p class="text-danger">PENDING</p>';
            })
            ->addColumn('action', function ($confirmation) {
                if ($confirmation->status == 0) return '<div class="row pl-3">
                                                                <form action="' . route('confirmations.update', $confirmation->id) . '" method="POST">
                                                                    ' . method_field('put') . csrf_field() . '
                                                                    <button type="submit" class="btn btn-primary btn-sm mr-1" onclick="return AcceptFunction()">Accept</button>
                                                                </form>
                                                        </div>';
                if ($confirmation->shipping_status == 0) return '<div class="row pl-3">
                                                                    <a href="shippings/create/'.$confirmation->id.'" class="btn btn-success btn-sm mr-1">Shipping</a>
                                                                </div>'; 
            })
            ->rawColumns(['code', 'total_price', 'photo', 'status', 'action'])
            ->toJson();
        }
        return view('pages.admin.confirmation.index');
    }

    public function show($id)
    {
        $confirmation = Confirmation::findOrFail($id);
        return view('pages.admin.confirmation.details', ['confirmation' => $confirmation]);
    }

    public function update($id)
    {   
        $confirmation = Confirmation::findOrFail($id);
        $confirmation->status = 1;
        $confirmation->shipping_status = 1;
        $confirmation->save();
        $transaction = $confirmation->transaction;
        $transaction->transaction_status = "SUCCESS";
        $transaction->save();
        return redirect('admin/confirmations')->with(
            ['message' => 'Transaksi dengan code ' .$transaction->code. ' berhasil divalidasi.'
        ]);
    }
}
