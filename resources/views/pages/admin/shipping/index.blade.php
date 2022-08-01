@extends('layouts.admin')

@section('title')
Shippings
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Shippings</h2>
            <p class="dashboard-subtittle">List Of Shippings</p>
        </div>

        <div class="card">
            <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Transaction Code</th>
                                    <th scope="col">Resi</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Shipping Date</th>
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
        columns: 
        [
            {data: 'null', name: 'id', render: (data, type, row, meta) => meta.row+1},
            {data: 'code', name: 'code'},
            {data: 'resi', name: 'resi'},
            {data: 'status', name: 'status'},
            {data: 'date', name: 'date'},
        ]
    });
</script>
@endpush