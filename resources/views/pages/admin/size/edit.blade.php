@extends('layouts.admin')

@section('title')
Size Edit
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Size</h2>
            <p class="dashboard-subtittle">Edit Size</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('size.update', $item->id) }}" enctype="multipart/form-data" method="POST">
                    <!-- //PUT dan PATCH sama saja. -->
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Width</label>
                                <input type="number" class="form-control" name="width" value="{{ $item->width }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Lenght</label>
                                <input type="number" class="form-control" name="lenght" value="{{ $item->lenght }}" required>
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