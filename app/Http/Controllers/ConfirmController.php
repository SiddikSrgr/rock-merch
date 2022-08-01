<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Confirmation;
use Illuminate\Support\Facades\Auth;

class ConfirmController extends Controller
{
    public function index($id)
    {
        $transaction = Transaction::where('id', $id)->firstOrFail();
        if($transaction->transaction_status == 'CANCELLED'){
            return redirect()->back();
        } else {
            return view('pages.confirm', [
                'transaction' => $transaction
            ]); 
        }
    }

    public function store(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->transaction_status = "CONFIRMED";
        $transaction->save();
        $data = $request->all();
        $data['photo'] = $request->file('photo')->store('confirmations' , 'public');
        Confirmation::create([
            'transaction_id' => $id,
            'photo' => $data['photo'],
            'bank' => $data['bank'],
            'name' => $data['name'],
            'status' => 0,
            'shipping_status' => 0
        ]);
        return redirect('/transactions')->with(
            ['message' => 'Pembayaran transaksi dengan code ' .$transaction->code. ' berhasil 
            dikonfirmasi, silahkan menunggu validasi ADMIN.'
        ]);
    }
}
