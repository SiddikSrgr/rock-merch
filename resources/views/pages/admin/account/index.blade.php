@extends('layouts.admin')

@section('title')
Account
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Account</h2>
            <p class="dashboard-subtittle">Admin Account</p>
        </div>

        <div class="card">
            <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Photo</th>
                                    <th>City</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr>
                                <td>{{$admin->name}}</td>
                                <td>{{$admin->email}}</td>
                                <td>
                                    <a href="{{ asset('storage/'. $admin->photo) }}">
                                        <img src="{{ asset('storage/'. $admin->photo) }}" style="max-height: 48px;">
                                    </a>
                                </td>
                                @php $city = \App\Models\City::find($admin->city_id); @endphp
                                <td>{{$city->name}}</td>
                                <td><a href="/admin/account/{{$admin->id}}/edit" class="btn btn-sm btn-warning">Edit</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection