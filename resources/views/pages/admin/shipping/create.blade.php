@extends('layouts.admin')

@section('title')
Shipping Create
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Shipping</h2>
            <p class="dashboard-subtittle">Add New Shipping</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('shippings.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Transaction Code</label>
                                <select name="confirmation_id" class="form-control" required>
                                    <option value="{{ $confirmation->id }}">{{ $confirmation->transaction->code }}</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-12">
                                <div class="form-group">
                                <label>Resi</label>
                                <input type="text" class="form-control" name="resi" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="SHIPPING">SHIPPING</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-success px-5 mt-3">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection