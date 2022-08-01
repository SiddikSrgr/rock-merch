<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\Review;

class DetailController extends Controller
{
    public function index($id)
    {
        $product = Product::where('slug', $id)->firstOrFail();
        return view('pages.detail', [
            'product' => $product
        ]); 
    }

    public function store(Request $request, $id)
    {
        $stock = Stock::where([ ['size_id', '=' , $request->size_id], ['product_id', '=', $id] ])->pluck('stock')->first();
        
        if($request->qty > $stock){
            return redirect()->back()->with(['message' => 'Jumlah Qty yang anda masukkan melebihi stok !']);
        } else {
            $data = [
                'product_id' => $id,
                'user_id' => Auth::user()->id,
                'size_id' => $request->size_id,
                'qty' => $request->qty
            ];
            Cart::create($data);
            return redirect('/cart');
        };
    }
}
