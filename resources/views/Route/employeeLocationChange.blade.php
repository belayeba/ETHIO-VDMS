@extends('layouts.navigation')
@section('content')

    <div class="wrapper">
        <div class="content-page">
            @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" 
                role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <div class="preloader" dir="ltr">
                <div class='body'>
                    <span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <div class='base'>
                        <span></span>
                        <div class='face'></div>
                    </div>
                </div>
                <div class='longfazers'>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <input type="hidden" name="table_name" id="table_name" value="">
            <input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">
            <div class="main-wrapper" style="min-height: 600px">
                <!-- Page Content  -->
                <div id="main-content" class="">
                    <section class="sms-breadcrumb mb-10 white-box">
                        <div class="container-fluid p-0">
                          
                        </div>
                    </section>

                    <section class="admin-visitor-area up_st_admin_visitor">
                        <div class="container-fluid p-0">
                            <div class="row justify-content-center">
                                <!-- Add New Cluster Form -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title mb-0">Do you want to change Location?</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('location_change_request') }}" accept-charset="UTF-8" name="cluster-form" id="cluster-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">Location Name <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="nameInput" name="location_name" placeholder="Your Location">
                                                </div>
                                                <div class="d-flex justify-content-center">
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
                                                                    data-bs-toggle="modal" data-bs-target="#viewEmployeeModal-1" 
                                                                    data-id="{{ $data->first()->id }}" 
                                                                    data-name="{{ $data->first()->user->username }}" 
                                                                    data-department="{{ $data->first()->user->department->name ?? 'N/A' }}">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modals -->
                                <div class="modal fade" id="viewEmployeeModal-1" tabindex="-1" role="dialog" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
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
                            </div>
                        </div>
                    </section>
                    
                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteLabel">Delete Confirmation</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Are you sure to delete ?</p>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <a id="delete_link" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                                   
                   <style>
                    @media only screen and (max-width: 768px) {
                        .col-md-4 {
                            width: 100%;
                        }
                        .col-md-8 {
                            width: 100%;
                        }

                        .card {
                            margin-bottom: 20px;
                        }

                        .table-responsive {
                            overflow-x: auto;
                        }

                        .modal-dialog {
                            max-width: 90%;
                        }
                    }

                    @media only screen and (max-width: 480px) {
                        .card {
                            padding: 10px;
                        }

                        .modal-dialog {
                            max-width: 100%;
                        }
                    }
                   </style>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    // View Route Modal
    document.querySelectorAll('[data-bs-target="#viewEmployeeModal-1"]').forEach(button =>{
        button.addEventListener("click", function () {
            let routeId = this.getAttribute('data-id');
            let Name = this.getAttribute('data-name');
            let Department = this.getAttribute('data-department');
            alert("coming");
            // document.getElementById('view_employee_name').textContent = Name;
            // document.getElementById('view_employee_department').textContent = Department;
        });
    });
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var editButtons = document.querySelectorAll('.edit-cluster-btn');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var cluster = this.getAttribute('data-cluster');
            var clusterId = this.getAttribute('data-cluster-id');
            var clusterName = this.getAttribute('data-cluster-name');

            // Update the form action to include the correct cluster ID (if needed)
            var form = document.querySelector('#cluster_modal form');
            // form.action = '/cluster/update' + cluster;  // Adjust this route to your actual update route

            // Populate the modal input field with the selected cluster's name
            document.getElementById('name').value = clusterName;
        });
    });
});

    </script>

    <script src="backend/js/datatable_extra.js"></script>
    <script src="backend/js/plugin.js"></script>
    <script>
        $(document).on('click', '#show_ai_text_generator', function () {
            var selected_template = $(this).data('selected_template');
            var ai_template = $('#ai_template');
            if (selected_template) {
                ai_template.val(selected_template);
                $('#ai_template').niceSelect('update');
            }
            $("#ai_text_generation_modal").modal('show');
        });

        $(document).on('change', '#ai_template', function (e) {
            let templateId = $(this).val();
            if (templateId == 1 || templateId == 11) {
                $('#titleDiv').addClass('d-none');
            } else {
                $('#titleDiv').removeClass('d-none');
            }
        });

        $('.dataTables_length label select').niceSelect();
        $('.dataTables_length label .nice-select').addClass('dataTable_select');
        $(document).on('click', '.dataTables_length label .nice-select', function () {
            $(this).toggleClass('open_selectlist');
        });
    </script>
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

    @endsection
