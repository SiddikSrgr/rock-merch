@extends('layouts.app') 

@section('title')
Review
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/transactions">Transactions</a></li>
          <li class="breadcrumb-item"><a href="/transaction/details/{{$transaction->transaction->id}}">Transaction Details</a></li>
          <li class="breadcrumb-item active" aria-current="page">Review</li>
        </ol>
      </nav> 

      <div class="row" data-aos="zoom-in">
          <div class="col-lg-6">

              <h6>{{ $transaction->product->name }} - Size {{ $transaction->size->name }} </h6>
              <img src="{{ asset('storage/'.$transaction->product->galleries->first()->photo) }}" style="width: 100px; height:100px" alt="">

                @if($transaction->review)
                    <form action="/review/{{$transaction->transaction->id}}/{{$transaction->review->id}}" method="post" class="mt-2">
                        @method('put')
                        @csrf
                            <div class="form-group">
                                <label>Review</label>
                                <textarea class="form-control text-left" rows="2" name="review" type="text" required>
                                    {{$transaction->review->review}}
                                </textarea>
                                <input type="hidden" name="product_id" value="{{$transaction->product->id}}" />
                                <input type="hidden" name="user_id" value="{{\Auth::user()->id}}" />
                                <input type="hidden" name="transaction_detail_id" value="{{$transaction->id}}" />
                            </div>
                            <div class="float-left">
                                <a href="/transaction/details/{{$transaction->transaction->id}}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                    </form>
                @else
                    <form action="/review/{{$transaction->transaction->id}}" method="post" class="mt-2">
                        @csrf
                            <div class="form-group">
                                <label>Review</label>
                                <textarea class="form-control" rows="2" name="review" type="text" required></textarea>
                                <input type="hidden" name="product_id" value="{{$transaction->product->id}}" />
                                <input type="hidden" name="user_id" value="{{\Auth::user()->id}}" />
                                <input type="hidden" name="transaction_detail_id" value="{{$transaction->id}}" />
                            </div>
                            <div class="float-left">
                                <a href="/transaction/details/{{$transaction->transaction->id}}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                    </form>
                @endif
            </div>
        </div>
</div>
@endsection
