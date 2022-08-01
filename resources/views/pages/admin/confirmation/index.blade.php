@extends('layouts.admin')

@section('title')
Confirmations
@endsection

@section('content')
<!-- Page Content -->
<div class="col-md-9 ml-sm-auto col-lg-10 px-md-4 bg-light">
    <div class="container">
        <div class="dashboard-heading mt-3">
            <h2 class="dashboard-tittle">Confirmations</h2>
            <p class="dashboard-subtittle">List Of Confirmations</p>
        </div>

        @if(session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          {{ session('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th scope="col">Transaction Code</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Bank</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
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
            {data: 'total_price', name: 'total_price', render: $.fn.dataTable.render.number( ',', '.', 0, 'IDR ' )},
            {data: 'photo', name: 'photo'},
            {data: 'bank', name: 'bank'},
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchcable: false, width: '15%'},
        ]
    });
</script>
<script>
    function AcceptFunction() {
        if (confirm('Are you sure you want to Accept this confirmation ? Status will change to ACCEPTED'))
            return true;
        else {
            return false;
        }
    }
</script> 
@endpush