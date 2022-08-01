<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index($transactionDetailId, $productId)
    {
        $transaction = TransactionDetail::find($transactionDetailId);
        $product = Product::find($productId);
        return view('pages.review', ['product' => $product, 'transaction' => $transaction]);
    }

    public function store(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        Review::create($request->all());
        return redirect()->route('transaction-details', $transaction->id);
    }

    public function update(Request $request, $transactionId, $reviewId)
    {
        $review = Review::find($reviewId);
        $transaction = Transaction::find($transactionId);
        $review->update($request->all());
        return redirect()->route('transaction-details', $transaction->id);
    }
}
