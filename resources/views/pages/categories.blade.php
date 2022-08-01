@extends('layouts.app')

@section('title')
Categories
@endsection

@section('content')
<div class="container" data-aos="fade-down">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
      </nav> 
    </div>

    <div class="container mt-4" data-aos="fade-up">
        <h5>All Categories</h5>
    </div>

    <div class="container" data-aos="fade-up">
        <div class="row">
        @forelse ($categories as $category)
            <div class="col-md-3 mb-3">
                <a href="/categories/{{$category->slug}}">
                    <div class="card">
                        <div class="card-body text-center zoom-logo">
                            <img src="{{ asset('storage/'.$category->photo) }}" style="width: 200px;height: 200px;" alt="">
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-6" data-aos="fade-up" data-aos-delay="100">
                No Categories Found
            </div>
        @endforelse
        </div>
    </div>

    <div class="container mt-4" data-aos="fade-up">
        <h5>All Products</h5>
    </div>

    <div class="container" data-aos="fade-up">
      <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
              <a href="/detail/{{$product->slug}}">
                <div class="card mb-4">
                    <div class="card-body text-center zoom-product">
                        <img src="{{ asset('storage/'.$product->galleries->first()->photo) }}" style="width: 300px;height: 300px;" alt="">
                        <h5 class="card-text text-dark">{{ $product->name }}</h5>
                        <h6 class="card-text text-danger">IDR {{ number_format($product->price) }}</h6>
                    </div>
                </div>
              </a>
            </div>
        @endforeach
      </div>
    </div>
@endsection