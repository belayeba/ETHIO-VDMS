@extends('layouts.navigation')
@section('content')

    <div class="wrapper">
        <div class="content-page">
        @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" 
                role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Error - </strong> {!! session('error_message') !!}
            </div>
        @endif
        
        @if(Session::has('success_message'))
            <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5"
                role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong> Success- </strong> {!! session('success_message') !!} 
            </div>
        @endif

            <div class="main-wrapper" style="min-height: 600px">
               
                <div id="main-content">
                    <section class="sms-breadcrumb mb-10 white-box">
                        <div class="container-fluid p-0">
                        </div>
                    </section>

                    <section class="admin-visitor-area up_st_admin_visitor">
                        <div class="container-fluid p-0">
                            <div class="row justify-content-center">

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title mb-0">Route Assignment</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('employeeService.store') }}" accept-charset="UTF-8" name="route_assigning_form" id="route_assigning_form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="route">Route</label>
                                                    <div class="col-md-9">
                                                        <select id="route_id" name="route_id" class="form-select" required>
                                                            <option value="">Select Route</option>
                                                            @foreach($routes as $route)
                                                                <option value="{{ $route->route_id }}">{{ $route->route_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="TogglePackage">
                                                    <div class="row">
                                                        <p class="mb-1 fw-bold text-muted">Select People</p>
                                                        <select id="multiSelect" name="people_id[]" class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Select People ..." style="height: 200px;">
                                                            <optgroup label="Users/Employees">
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center mt-3">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title mb-0">Route List</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lms_table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Route</th>
                                                            <th>Vehicle</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($routeUser as $route_id => $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->first()->route->route_name }}</td>
                                                            <td>{{ $data->first()->route->vehicle->plate_number }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-info rounded-pill" 
                                                                    data-bs-toggle="modal" data-bs-target="#viewEmployeeModal-{{ $loop->index }}" 
                                                                    data-id="{{ $data->first()->id }}" 
                                                                    data-name="{{ $data->first()->user->username }}" 
                                                                    data-department="{{ $data->first()->user->department->name }}">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modals -->
                                @foreach ($routeUser as $route_id => $data)
                                <div class="modal fade" id="viewEmployeeModal-{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewEmployeeModalLabel">View Employee Details for Route {{ $data->first()->route->route_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Employee</th>
                                                            <th>Department</th>
                                                            <th>Action</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $dat)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td> <!-- Loop iteration for numbering -->
                                                            <td>{{ optional($dat->user)->username ?? 'N/A' }}</td> <!-- Ensure user exists -->
                                                            <td>{{ optional($dat->user->department)->name ?? 'N/A' }}</td> <!-- Ensure department exists -->
                                                            <td>
                                                                <!-- Remove button/icon -->
                                                                <form action="{{ route('routeUser.destroy', $dat->employee_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this employee?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                
                    <!-- Footer -->
                    <footer class="footer-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center mt-5">
                                    <p class="p-3 mb-0">Copyright © 2024. All rights reserved | Made By Ai</p>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
    // View Route Modal
    document.querySelectorAll('[data-bs-target="#viewEmployeeModal"]').forEach(button => {
        button.addEventListener("click", function () {
            let routeId = this.getAttribute('data-id');
            let Name = this.getAttribute('data-name');
            let Department = this.getAttribute('data-department');
            
            document.getElementById('view_employee_name').textContent = Name;
            document.getElementById('view_employee_department').textContent = Department;
        });
    });
    });
    </script>

<script>
    $(document).ready(function() {
        $('#multiSelect').select2({
            width: '100%',
            dropdownAutoWidth: true,
            placeholder: 'Select People ...',
            allowClear: true,
            closeOnSelect: false,
            theme: 'bootstrap4',
            templateResult: formatState,
            escapeMarkup: function(m) { return m; }
        });
    });

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }

        var baseUrl = "/user/avatar/";
        var $state = $(
            '<span><img src="' + baseUrl + state.element.value + '" class="img-flag" /> ' + state.text + '</span>'
        );
        
        return $state;
    }
</script>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

@endsection
