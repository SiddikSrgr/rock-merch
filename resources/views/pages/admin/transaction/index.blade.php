@extends('layouts.admin')

@section('title')
Transactions
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Transactions</h2>
            <p class="dashboard-subtittle">List Of Transactions</p>
        </div>

        <div class="card">
            <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Shipping Status</th>
                                    <th scope="col">Action</th>
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
            {data: 'user.name', name: 'user.name'},
            {data: 'total_price', name: 'total_price', render: $.fn.dataTable.render.number( ',', '.', 0, 'IDR ' )},
            {data: 'transaction_status', name: 'transaction_status'},
            {data: 'shipping_status', name: 'shipping_status'},
            {data: 'action', name: 'action', orderable: false, searchcable: false, width: '15%'},
        ]
    });
</script>
@endpush