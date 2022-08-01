<?php

namespace App\Http\Controllers;

use  App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->latest()->get();
        $admin = User::where('role', 'ADMIN')->first();
        $weightTotal = 0;
        
        foreach($carts as $cart)
        {
            $stock = $cart->product->stocks->first()->stock;
            $qty = $cart->qty;
            if($stock == 0){
                return $this->destroy($cart->id);
            }
            if($qty > $stock){
                $cart->update(['qty' => $stock]);
            }
            $weightTotal += $cart->product->weight * $cart->qty;
        }
        return view('pages.cart', ['carts' => $carts, 'weightTotal' => $weightTotal, 'admin' => $admin]);
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect('/cart');
    }    
}
 