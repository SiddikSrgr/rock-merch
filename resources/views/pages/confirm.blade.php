@extends('layouts.confirm') 

@section('title')
Confirm
@endsection

@push('addon-style')
<style>
    .verikal_center{
     border: 1px solid #E9ECEF;
     height: 50vh;
     margin-left: 30px;
    }
    .form{
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
<div class="container mt-1" data-aos="fade-down">
    <div class="row justify-content-center">
        <h5 class="text-secondary">Payment Confirmation</h5>
    </div>
</div>


<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5" data-aos="fade-right">
                <p>Code : {{$transaction->code}}</p>
                <p>Total : <span class="text-danger font-weight-bold">IDR {{ number_format($transaction->total_price) }}</span></p>
                <div class="row mb-4 mt-4">
                    <div class="col-lg-2">
                        <img src="{{ asset('storage/bca.png') }}" style="width:70px; height:40px">
                    </div>
                    <div class="col-lg-10">
                        <p>Bank Central Asia</p>
                        <p>2209 8776</p>
                        <p>Rahmat Ujang</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <img src="{{ asset('storage/mandiri.jpg') }}" style="width:70px; height:40px">
                    </div>
                    <div class="col-lg-10">
                        <p>Bank Mandiri</p>
                        <p>2209 8776</p>
                        <p>Rahmat Ujang</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-1 d-lg-flex d-sm-none d-none">
                <div class="verikal_center"></div>
            </div>

            @if($transaction->confirmation)
            <div class="col-lg-5" data-aos="fade-left">
                <div class="form">
                    <label for="photo">Bukti Transfer</label>
                    <br> 
                    <a href="{{ asset('storage/'.$transaction->confirmation->photo) }}">
                        <img src="{{ asset('storage/'.$transaction->confirmation->photo) }}" alt="Bukti Transfer" style="width:70%;max-width:70px">
                    </a>
                </div>
                <div class="form">
                    <label for="bank">Asal Bank</label>
                    <input type="text" class="form-control" id="bank" value="{{$transaction->confirmation->bank}}" disabled>
                </div>
                <div class="form">
                    <label for="name">Nama Pengirim</label>
                    <input type="text" class="form-control" id="name" value="{{$transaction->confirmation->name}}" disabled>
                </div>
            </div>
            <div data-aos="fade-up">
                <div class="row justify-content-center mt-3">
                    <a href="/transactions" class="btn btn-primary px-5">Back</a>
                </div>
            </div>
            @else
            <div class="col-lg-5" data-aos="fade-left">
                <form action="/confirm/{{$transaction->id}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form">
                        <label for="photo">Upload Bukti Transfer</label>
                        <input type="file" class="form-control-file" id="photo" name="photo" required>
                    </div>
                    <div class="form">
                        <label for="bank">Asal Bank</label>
                        <select class="form-control" id="bank" name="bank" required>
                            <option value="BCA">BCA</option>
                            <option value="MANDIRI">MANDIRI</option>
                        </select>
                    </div>
                    <div class="form">
                        <label for="name">Nama Pengirim</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
            </div>
                    <div data-aos="fade-up">
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
                        </div>
                </form>
                        <div class="row justify-content-center mt-2">
                            <a href="/transactions" class="btn btn-light px-5">Cancel</a>
                        </div>
                    </div>
            @endif
        </div>
</div>
@endsection
