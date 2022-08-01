<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Cart;
use  App\Models\Transaction;
use  App\Models\TransactionDetail;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $code = 'RM-' . mt_rand(000000, 999999);
        $carts = Cart::with(['product', 'user'])->where('user_id', $user->id)->get();
        $expired_at = Carbon::now()->addDay();

        // Transaction create
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'shipping_price' => $request->ongkir,
            'total_price' => (int) $request->grand_total, 
            'transaction_status' => 'PENDING',
            'resi' => '',
            'shipping_status' => 'PENDING',
            'code' => $code,
            'courier' => $request->courier,
            'expired_at' => $expired_at,
            'address' => $request->address,
            'province_id' => $request->province_destination_id,
            'regencies_id' => $request->city_destination_id,
            'zip_code' => $request->postal_code,
            'phone_number' => $request->mobile
        ]);
        foreach($carts as $cart){
            $product_stock = $cart->product->stocks->where('size_id', $cart->size_id)->first();
            $product_stock->update(['stock' => $product_stock->stock - $cart->qty]);
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product_id,
                'qty' => $cart->qty,
                'size_id' => $cart->size_id,
                'price' =>  $cart->product->price
            ]);
        } 

        // Hapus data cart
        Cart::where('user_id', $user->id)->delete();
        return redirect()->route('confirm', $transaction->id);
    }
}
