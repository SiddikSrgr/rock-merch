@extends('layouts.app')

@section('title')
Transactions
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Transactions</li>
        </ol>
      </nav> 

      @if(session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          {{ session('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

        <div class="row" data-aos="zoom-in">
            <div class="col-lg-12  table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Shipping Status</th>
                        <th scope="col">Confirm Before</th>
                        <th scope="col">Confirm Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                
                    @forelse($transactions as $transaction)
                      <tr>
                        <td class="cart-detail">{{ $transaction->code }}</td>
                        <td class="cart-detail">IDR {{ number_format($transaction->total_price) }}</td>
                        <td class="cart-detail @if($transaction->transaction_status == 'PENDING' || $transaction->transaction_status == 'CANCELLED') text-danger @else text-success @endif">{{ $transaction->transaction_status }}</td>
                        <td class="cart-detail @if($transaction->shipping_status == 'PENDING'|| $transaction->shipping_status == 'CANCELLED') text-danger @else text-success @endif">{{ $transaction->shipping_status }}</td>
                        <td  id="timeLapse{{$transaction->id}}" class="cart-detail @if($transaction->transaction_status == 'PENDING') text-primary @else text-danger @endif"></td>
                        <td class="cart-detail">
                          @if($transaction->confirmation)
                          <p class="text-success">CONFIRMED</p>
                          @else
                          <p class="text-danger">NOT CONFIRMED</p>
                          @endif
                        </td>
                        <td class="cart-detail">
                          @if($transaction->transaction_status !== 'CANCELLED')
                            <a href="/confirm/{{$transaction->id}}" class="btn btn-sm btn-primary">Confirmation</a>
                          @endif
                            <a href="/transaction/details/{{$transaction->id}}" class="btn btn-sm btn-warning">Details</a>
                        </td>
                      </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-danger">No Transactions Found</td></tr>
                    @endforelse
                    
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection

@push('addon-script')
<script>
  var countdowns = [
  @foreach ($transactions as $transaction)
  {
    id: {{$transaction->id}},
    date: new Date("{{ \Carbon\Carbon::parse($transaction->expired_at)->format('M, j Y H:i:s') }}").getTime(),
    status: "{{$transaction->transaction_status}}",
    confirm: @if($transaction->confirmation) 1 @else 0 @endif
  },
  @endforeach
  ];

  // Update the count down every 1 second
  var timer = setInterval(function() {
    // Get todays date and time
    var now = Date.now();

    var index = countdowns.length - 1;

    // we have to loop backwards since we will be removing
    // countdowns when they are finished
    while(index >= 0) {
      var countdown = countdowns[index];

      // Find the distance between now and the count down date
      var distance = countdown.date - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      var timerElement = document.getElementById("timeLapse" + countdown.id);
      // If the count down is over, write some text 
      if (distance < 0 && countdown.confirm == 0) {
        timerElement.innerHTML = "EXPIRED";
        // this timer is done, remove it
        countdowns.splice(index, 1);

        if(countdown.status == 'PENDING'){
          window.location.href = "/transaction-expired/" + countdown.id;
        }

      } else if (countdown.confirm == 1) {
        timerElement.innerHTML = " -  :  -  :  -";
        // this timer is done, remove it
        countdowns.splice(index, 1);
      } else {
        timerElement.innerHTML =  hours + "h " + minutes + "m " + seconds + "s "; 
      }
      index -= 1;
    }

    // if all countdowns have finished, stop timer
    if (countdowns.length < 1) {
      clearInterval(timer);
    }
  }, 1000);
</script>
@endpush