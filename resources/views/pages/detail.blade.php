@extends('layouts.app')

@section('title')
Product Detail
@endsection

@section('content')
    <div class="container" data-aos="fade-down">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
          </ol>
        </nav>
        @if(session()->has('message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
      </div>

      <div class="container" id="gallery">
        <div class="row">
          <div class="col-lg-6 mb-3" data-aos="fade-right">
            <div class="card">
                <div class="card-body card-product text-center">
                    <transition name="slide-fade" mode="out-in">
                      <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="w-75 main-image" alt="">
                    </transition>
                </div>
            </div>
            <div class="col-lg-12 p-0">
              <div class="row">
                <div class="col-3 mt-2" v-for="(photo, index) in photos" :key="photo.id">
                  <a href="#" @click="changeActive(index)">
                    <div class="card thumbnail-image" :class="{ active: index == activePhoto }">
                      <div class="card-body">
                          <img :src="photo.url" class="w-100" alt="">
                        </div>
                      </div>   
                  </a>
                  </div>
                </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left">
              <h5 class="card-text text-dark mb-3">{{ $product->name }}</h5>
              <h5 class="card-text text-danger mb-3">IDR {{ number_format($product->price) }}</h5>
              @foreach($product->stocks as $stock)
              <p class="text-secondary mt-4 mb-4" style="line-height: 5px;">Size {{ $stock->size->name }} : Stock {{ $stock->stock }}</p>
              @endforeach
              <form action="/detail/{{$product->id}}" method="POST" enctype="multipart/form-data">
                @csrf 
                  <div class="row my-2">
                      <div class="col-lg-6 d-flex form-group">
                          <label class="py-1">Size</label>
                          <select class="form-control ml-2" name="size_id" required>
                            @foreach($product->stocks as $stock)
                              <option value="{{ $stock->size->id }}">{{ $stock->size->name }}</option>
                            @endforeach
                          </select>
                      </div>
                      <div class="col-lg-6 d-flex form-group">
                          <label class="py-1">Qty</label> 
                          <input type="number" min="1" class="form-control ml-2" name="qty" placeholder="0" required/>                     
                      </div>
                  </div>
                  @auth
                  <button type="submit" class="btn btn-success px-5 text-white mb-3">Add to Cart</button>
                  @else
                  <a href="{{ route('login') }}" class="btn btn-success px-5 text-white mb-3">Sign in to buy</a>
                  @endauth
              </form>
        </div>
      </div>
      
      <hr>
      <div class="container mt-4">
        <div class="row" data-aos="fade-right">
          <div class="col-lg-10">
            <h6 class="mb-3">Description</h6>
            <div class="mt-3">
              {!! $product->description !!}
            </div>
            <div class="mb-3">
              <p>Weight : {{ $product->weight }} gram.</p>
            </div>
          </div>
        </div>
        <hr> 

        <div data-aos="fade-left">
          <h6 class="mb-3">Customer Review ({{$product->reviews->count()}})</h6> 
          @forelse($product->reviews->sortDesc() as $review)
          <div class="row">
            <div class="col-lg-8">
              <div class="media my-2">
                <img src="{{ asset('storage/'. $review->user->photo) }}" class="align-self-start user-review mr-3 rounded-circle profile-picture" alt="...">
                <div class="media-body">
                  <span class="mt-0 font-weight-bold">{{$review->user->name}}</span>
                  <span class="text-secondary">- Size {{$review->transaction->size->name}}</span>
                  <p>{{$review->review}}</p>
                </div>
              </div>
            </div>
          </div>
          @empty
  
          @endforelse
        </div>
      </div>
@endsection
 
@push('addon-script') 
<script src="/vendor/vue/vue.js"></script>
<script>
      var gallery = new Vue({
          el: "#gallery",
          mounted() {
              AOS.init();
          },
          data: {
              activePhoto: 0,
              photos: [
                @foreach($product->galleries as $gallery)
                {
                    id: {{ $gallery->id }},
                    url: "{{ asset('storage/'.$gallery->photo) }}",
                },
                @endforeach
              ],
          },
          methods: {
              changeActive(id) {
                  this.activePhoto = id;
              }
          },
      });
</script>
@endpush