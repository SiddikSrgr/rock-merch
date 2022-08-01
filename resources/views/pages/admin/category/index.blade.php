@extends('layouts.admin')

@section('title')
Categories
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Categories</h2>
            <p class="dashboard-subtittle">List Of Categories</p>
        </div>

        <div class="card">
            <div class="card-body">
                <a href="/admin/category/create" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus-circle"></i> Add</a>
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script') 
<script>
    var datatable = $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: '{!! url()->current() !!}',
        },
        columns: [
            {
                data: 'null',
                name: 'id',
                render: (data, type, row, meta) => meta.row+1
            },
            {
                data: 'photo',
                name: 'photo'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchcable: false,
                width: '15%'
            },
        ]
    });
</script>
<script>
    function DeleteFunction() {
        if (confirm('Are you sure you want to delete this category?'))
            return true;
        else {
            return false;
        }
    }
</script> 
@endpush