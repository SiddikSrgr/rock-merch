@extends('layouts.admin')

@section('title')
Product Edit
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Products</h2>
            <p class="dashboard-subtittle">Edit Product</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" value="{{ $product->price }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Weight (gram)</label>
                                <input type="number" class="form-control" name="weight" value="{{ $product->weight }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="editor">{!! $product->description !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-success btn-block px-5 mt-3">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body"> 
                <h6 class="text-dark">Product Thumbnails</h6>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                @foreach($product->galleries as $gallery)
                                <div class="col-md-2 my-2">
                                    <div class="gallery-container">
                                        <img src="{{ asset('storage/'. $gallery->photo) ?? '' }}" alt="" class="w-100">

                                        <form action="/admin/gallery/{{$gallery->id}}" method="POST">
                                        @csrf
                                        @method('delete')
                                            <button type="submit" class="delete-gallery" data-toggle="tooltip" data-placement="top" title="Delete Photo" onclick="return confirm('Are you sure to delete this gallery?')">
                                                <img src="/img/product-card-remove.svg" alt="">
                                            </button>
                                        </form>

                                    </div>
                                </div>
                                @endforeach
                           
                                <div class="col-md-2">
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <form action="/admin/gallery" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="file" id="file" name="photos[]" style="display: none;" onchange="form.submit()" multiple>
                                                <a type="button" onclick="thisFileUpload()" data-toggle="tooltip" data-placement="bottom" title="Add Photo">
                                                    <img src="/img/add_photo.jpg" class="w-100" alt="">
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>

    </div>
</div>
@endsection

@push('addon-script')
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
<script>
    function thisFileUpload() {
        document.getElementById("file").click()
    };
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endpush