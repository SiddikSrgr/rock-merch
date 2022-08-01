@extends('layouts.admin')

@section('title')
Stock Edit
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Stock</h2>
            <p class="dashboard-subtittle">Edit Stock</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('stock.update', $item->id) }}" enctype="multipart/form-data" method="POST">
                    <!-- //PUT dan PATCH sama saja. -->
                    @method('PUT')
                    @csrf
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product</label>
                                <select name="product_id" class="form-control" required>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Size</label>
                                <select name="size_id" class="form-control" required>
                                    @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="text" name="stock" class="form-control" value="{{ $item->stock }}" required>
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