@extends('layouts.navigation')

@section('content')

<!-- DataTables CSS -->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

<!-- Content -->
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">User Lists</h4>
                        <a href="{{ route('user_create') }}" class="btn btn-primary rounded-pill">Create</a>
                    </div>
                    <div class="card-body">
                        <table 
                               class="user_datatable table table-centered mb-0 table-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Start date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div> <!-- end row-->
    </div>
</div>
<!-- END wrapper -->

<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(function () {
        var table = $('.user_datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: "{{ route('users.list.show') }}",
            columns: [
                { data: 'first_name', name: 'first_name' },
                { data: 'email', name: 'email' },
                { data: 'phone_number', name: 'phone_number' },
                { data: 'department_id', name: 'department_id' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action' },
                
            ]
        });
    });
</script>

<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/vendor.min.js') }}"></script> -->
<!-- <script src="{{ asset('assets/js/app.min.js') }}"></script> -->

@endsection
