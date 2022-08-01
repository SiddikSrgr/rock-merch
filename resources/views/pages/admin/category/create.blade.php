@extends('layouts.admin')

@section('title')
Category Create
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Category</h2>
            <p class="dashboard-subtittle">Add New Category</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" autofocus required>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label>Photo</label>
                                <input type="file" class="form-control" name="photo" required>
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