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
                    <div class="container-fluid p-0"></div>
                </section>
        
                <section class="admin-visitor-area up_st_admin_visitor">
                    <div class="container-fluid p-0">
                        <div class="row justify-content-center">
                            <!-- Assignment Form -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0">Route Assignment</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('employeeService.store') }}" id="route_assigning_form">
                                            @csrf
                                            <!-- Route Selection -->
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
        
                                            <!-- Employee Selection Table -->
                                            <div class="row">
                                                <p class="mb-1 fw-bold text-muted">Select People</p>
                                                <div class="mb-3">
                                                    <input
                                                        type="text"
                                                        id="employeeSearch"
                                                        class="form-control"
                                                        placeholder="Search by name"
                                                    />
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table" id="employee_table">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="select_all"></th>
                                                                <th>Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($users as $user)
                                                                <tr>
                                                                    <td>
                                                                        <input
                                                                            type="checkbox"
                                                                            name="people_id[]"
                                                                            value="{{ $user->id }}"
                                                                            class="select_employee"
                                                                        />
                                                                    </td>
                                                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center mt-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Route List -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0">Route List</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="route_list_table" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Route</th>
                                                        <th>Vehicle</th>
                                                        <th>Driver Name</th>
                                                        <th>Driver Phone</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($routeUser as $route_id => $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->first()->route->route_name }}</td>
                                                            <td>{{ $data->first()->route->vehicle->plate_number }}</td>
                                                            <td>{{ $data->first()->route->vehicle->driver->user->first_name ?? null }}</td>
                                                            <td>{{ $data->first()->route->driver_phone }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-info rounded-pill" 
                                                                    data-bs-toggle="modal" data-bs-target="#viewEmployeeModal-{{ $loop->index }}" 
                                                                    data-id="{{ $data->first()->id }}" 
                                                                    data-name="{{ $data->first()->user->username }}" 
                                                                    data-department="{{ $data->first()->user->department->name ?? 'N/A' }}">
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
                        </div>
                    </div>
                </section>
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
                                                            <th>Employee Name</th>
                                                            <th>Location</th>
                                                            <th>Employee Phone</th>
                                                            <th>Action</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $dat)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td> <!-- Loop iteration for numbering -->
                                                            <td>{{ optional($dat->user)->first_name ?? 'N/A' }}</td> <!-- Ensure user exists -->
                                                            <td>{{ $data->first()->route->route_name  ?? 'N/A' }}</td> <!-- Ensure location exists -->
                                                            <td>{{ $dat->user->phone_number ?? 'N/A' }}</td> <!-- Ensure phone exists -->
                                                            <td>
                                                                <!-- Remove button/icon -->
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#warning_alert">
                                                                    <i class="ri-delete-bin-line"></i>
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
                                <!-- Accept Alert Modal -->
                                <div id="warning_alert" class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('routeUser.destroy', $dat->employee_id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="request_id" id="request_id">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="ri-alert-line h1 text-warning"></i>
                                                    <h4 class="mt-2">Warning</h4>
                                                    <h5 class="mt-3">
                                                        Are you sure you want to remove this employee?</br> This action
                                                        cannot be
                                                        undone.
                                                    </h5>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        id="confirmDelete">Yes,
                                                        Accept</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                                @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
    // View Route Modal
    document.querySelectorAll('[data-bs-target="#viewEmployeeModal"]').forEach(button =>{
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

        <script>
            document.getElementById('employeeSearch').addEventListener('keyup', function () {
                const searchValue = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('#employee_table tbody tr');

                tableRows.forEach((row) => {
                    const name = row.cells[1].textContent.toLowerCase();

                    if (name.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Select All Functionality
            document.getElementById('select_all').addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.select_employee');
                checkboxes.forEach((checkbox) => (checkbox.checked = this.checked));
            });
        </script>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

@endsection
