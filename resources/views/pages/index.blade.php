@extends('layouts.app')

@section('title')
Home
@endsection

@section('content')
<div class="container my-2" data-aos="zoom-in">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li class="active" data-target="#storeCarousel" data-slide-to="0"></li>
            <li data-target="#storeCarousel" data-slide-to="1"></li>
          </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('storage/1.png') }}" class="d-block w-100" alt="..." style="height: 400px;">
            <div class="carousel-caption d-none d-md-block">
             
            </div>
          </div>
          <div class="carousel-item">
            <img src="{{ asset('storage/1.png') }}" class="d-block w-100" alt="..." style="height: 400px;">
            <div class="carousel-caption d-none d-md-block">
             
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </button>
      </div>
    </div> 

    <div class="container mt-4" data-aos="fade-up">
        <h5>Trend Categories</h5>
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

    <div class="product-list">
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
    </div>
@endsection