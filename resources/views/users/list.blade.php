@extends('layouts.navigation')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

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
                        <table id="fixed-header-datatable"
                               class="table user_datatable dt-responsive nowrap table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Start date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->department_id }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    </tr>
                                @endforeach
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
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'department', name: 'department' },
                { data: 'start_date', name: 'start_date' }
            ]
        });
    });
</script>

@endsection
