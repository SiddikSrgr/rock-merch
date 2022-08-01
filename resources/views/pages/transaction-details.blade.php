@extends('layouts.app')

@section('title')
Transaction Details
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/transactions">Transaction</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{$transaction->code}} - Transaction Details</li>
        </ol>
      </nav> 

      <div class="row mb-3">
        <div class="col-lg-4">
          <h6>Transaction Date : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->created_at)->format('j F Y H:i:s') }}</span></h6>
          <h6>Will Expired Date : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->expired_at)->format('j F Y H:i:s') }}</span></h6>
          @if($transaction->confirmation)
          <h6>Confirm Date : <span class="font-weight-normal">{{ \Carbon\Carbon::parse($transaction->confirmation->created_at)->format('j F Y H:i:s') }}</span></h6>
          @endif
        </div>
        <div class="col-lg-4">
          <h6>Shipping Cost : <span class="font-weight-normal">IDR {{ number_format($transaction->shipping_price) }}</span></h6>
          <h6>Courier : <span class="font-weight-normal">{{strtoupper($transaction->courier)}}</span></h6>
          <h6>Total Price : <span class="font-weight-normal">IDR {{ number_format($transaction->total_price) }}</span></h6>
        </div>
        <div class="col-lg-4">
          <h6>Shipping Address : <span class="font-weight-normal">{{$transaction->address}}, 
            {{\App\Models\City::where('id', $transaction->regencies_id)->first()->name}}, 
            {{\App\Models\Province::where('id', $transaction->province_id)->first()->name}},
            {{$transaction->zip_code}}</span>
          </h6>
        </div>
      </div>
      <div class="row" data-aos="zoom-in">
            <div class="col-lg-12  table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Weight</th> 
                        <th scope="col">Size</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                    @forelse($transaction->transactions as $transaction)
                      <tr>
                        <td><img src="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}" style="width: 100px; height:100px" alt=""></td>
                        <td class="cart-detail">{{ $transaction->product->name }}</td>
                        <td class="cart-detail">IDR {{ number_format($transaction->price) }}</td>
                        <td class="cart-detail">{{ $transaction->product->weight }} gr</td>
                        <td class="cart-detail">{{ $transaction->size->name }}</td>
                        <td class="cart-detail">{{ $transaction->qty }}</td>
                        <td class="cart-detail">IDR {{ number_format($transaction->price * $transaction->qty) }}</td>
                        <td class="cart-detail">
                        @if($transaction->transaction->shipping_status == 'SHIPPING')
                            <a href="/review/{{$transaction->id}}/{{$transaction->product->id}}" class="btn btn-sm btn-success">Review</a>
                        @endif
                        </td>
                      </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-danger">No Transaction Found</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection