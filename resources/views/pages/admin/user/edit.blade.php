@extends('layouts.admin')

@section('title')
User Edit
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">User</h2>
            <p class="dashboard-subtittle">Edit User</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.update', $item->id) }}" enctype="multipart/form-data" method="POST">
                    <!-- //PUT dan PATCH sama saja. -->
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $item->email }}" required>
                                @error('email')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                <small class="form-text text-muted">kosongkan jika tidak ingin ganti photo</small>
                                @error('photo')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                <small class="form-text text-muted">kosongkan jika tidak ingin ganti password</small>
                                @error('password')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password_confirmation">Password Confimation</label>
                                <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                                <small class="form-text text-muted">kosongkan jika tidak ingin ganti password</small>
                                @error('password_confirmation')
                                <span class="invalid-feedback mb-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                                @enderror
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