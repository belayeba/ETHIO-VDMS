@extends('layouts.navigation')
@section('content')
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.3em 0.5em;
            margin-right: 0.2em;
        }

        .remove-tag {
            cursor: pointer;
            margin-left: 0.3em;
        }
    </style>

    <div class="content-page">
        <div class="content">

            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Error - </strong> {!! session('error_message') !!}
                </div>
            @endif

            @if (Session::has('success_message'))
                <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong> Success- </strong> {!! session('success_message') !!}
                </div>
            @endif
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Form Section -->
                    <div class="col-12 col-lg-5">
                        <div class="card">
                           
                            <div class="card-body">
                                <!-- Form content -->

                                <form method="POST" action="{{ route('driver_request_post') }}" enctype="multipart/form-data">
                                    @csrf
                                    <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                        <li class="nav-item">
                                            <a class="nav-link rounded-0 py-2" id="displayprogresive">
                                                <i class="ri-settings-5-fill fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">Request Maintenance</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div id="progressbarwizard" style="display: none">
                                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                            <li class="nav-item">
                                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Reason</span>
                                                </a>
                                            </li>
                                           
                                         
                                            <li class="nav-item">
                                                <a href="#finish-3" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class=" ri-information-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Info</span>
                                                </a>
                                            </li>

                                        </ul>

                                        <div class="tab-content b-0 mb-0">

                                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                                <div
                                                    class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                                </div>
                                            </div>
                                                <div class="tab-pane" id="account-2">
                                                    <div class="row">

                                                        <div class="position-relative mb-3">
                                                            <div class="mb-6 position-relative" id="datepicker1">
                                                                <label class="form-label">Vehicle</label>
                                                                <select id="vehicl" name="vehicle" class="form-select" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($vehicle as $vehicle)
                                                                        <option value="{{ $vehicle->vehicle_id }}">{{ $vehicle->plate_number }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mb-3">
                                                            <div class="mb-6 position-relative">
                                                                <label class="form-label">Maintenance Type</label>
                                                                <select id="maintenance" name="maintenance_type" class="form-select" required>
                                                                    <option value="">Select</option>
                                                                    <option value="service">Service</option>
                                                                    <option value="accident">Accident</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <ul class="list-inline wizard mb-0">
                                                        <li class="next list-inline-item float-end">
                                                            <a href="javascript:void(0);" class="btn btn-info">Next <i
                                                                    class="ri-arrow-right-line ms-1"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>

                                            
                                                
                                                <div class="tab-pane" id="finish-3">
                                                    <div class="row">
                                                        <div class="position-relative mb-3">
                                                            <div class="mb-6 position-relative">
                                                                <label class="form-label">Current Mileage</label>
                                                                <input type="number" name="milage" class="form-control"
                                                                    placeholder="Enter current vehicle mileage" required>
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mb-3">
                                                            <div class="mb-6 position-relative">
                                                                <label class="form-label">Problem</label>
                                                                <textarea type="text" name="driver_inspection" class="form-control"
                                                                    rows="4"  style="resize: none;" required> </textarea>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <ul class="pager wizard mb-0 list-inline mt-1">
                                                        <li class="previous list-inline-item">
                                                            <button type="button" class="btn btn-light"><i
                                                                    class="ri-arrow-left-line me-1"></i> Back</button>
                                                        </li>
                                                        <li class="next list-inline-item float-end">
                                                            <button type="submit" class="btn btn-info">Submit</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            
                                        </div></br> <!-- end card-body-->
                                    </form>
                                    </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Table Section -->
                    <div class="col-12 col-lg-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatable" class="Temporary_datatable table table-centered mb-0 table-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Roll.no</th>
                                                <th>Vehicle</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                        </tbody>
                                    </table>

                                </div>
                                
                                <!-- Accept Alert Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form method="POST" action="{{route('temp_delete_request')}}">
                                            @csrf
                                            <input type="hidden" name="request_id" id="deleted_id">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="ri-alert-line h1 text-danger"></i>
                                                    <h4 class="mt-2">Warning</h4>
                                                    <h5 class="mt-3">
                                                        Are you sure you want to DELETE this request?</br> This action
                                                        cannot be
                                                        undone.
                                                    </h5>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger"
                                                        id="confirmDelete">Yes,
                                                        Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                              
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>



                <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

        <script>
            var table = $('.Temporary_datatable').DataTable({
                processing: true,
                pageLength: 5,
                serverSide: true,
                ajax: {
                    url: "{{ route('FetchMaintenanceRequest') }}",
                    data: function (d) {
                        d.customDataValue = 1;
                    }
                },    
                columns: [{
                        data: 'counter',
                        name: 'counter'
                    },
                    {
                        data: 'vehicle',
                        name: 'vehicle'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
                    
            $(document).ready(function() {
                    var RejectedId;
        
                    $(document).on('click', '.reject-btn', function() {
                        RejectedId = $(this).data('id');
        
                        $('#deleted_id').val(RejectedId);
                        $('#confirmationModal').modal('toggle');
                    });
                });
         

            document.getElementById('displayprogresive').addEventListener('click', function() {
                // Retrieve the div element to be toggled
                var targetDiv = document.getElementById('progressbarwizard');
                
                // Toggle the visibility of the div
                if (targetDiv.style.display === 'none') {
                    targetDiv.style.display = 'block';
                } else {
                    targetDiv.style.display = 'none';
                }
            });
    </script>


    <script src="assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>


    <script src="assets/js/pages/form-wizard.init.js"></script>
    <script>
        src = "{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" 
    </script>



    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
