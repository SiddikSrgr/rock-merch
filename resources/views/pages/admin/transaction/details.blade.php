@extends('layouts.admin')

@section('title')
Transaction Details
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Transaction Details</h2>
            <p class="dashboard-subtittle">List Of Transaction Details</p>
        </div>

        <div class="card">
            <div class="card-body">
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
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                        <tbody>
                            @forelse($transaction->transactions as $transaction)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$transaction->transaction->code}}</td>
                                <td>{{ $transaction->product->name }}</td>
                                <td><img src="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}" style="width: 90px; height:90px" alt=""></td>
                                <td>{{ $transaction->qty }}</td>
                                <td>IDR {{ number_format($transaction->price) }}</td>
                                <td>{{ $transaction->size->name }}</td>
                                <td>IDR {{ number_format($transaction->price * $transaction->qty) }}</td>
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
    </div>
</div>
@endsection