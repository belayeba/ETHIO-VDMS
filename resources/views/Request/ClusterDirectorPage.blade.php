@extends('layouts.navigation')
@section('content')

        <div class="content-page">
            <div class="content">
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
                    <!-- <h4 class="header-title mb-4">DIRECTOR PAGE</h4> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive"  id="table1">
                                        <h4 class="header-title mb-4">NEW Cluster Director REQUEST</h4>
                                       
                                        <table class="table cluster_director_datatable table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Requested By</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Location From</th>
                                                    <th>Location To</th>
                                                    <th>Requested At</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
        
                                        <!-- show all the information about the request modal -->
                                        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Request Details</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-5">Request reason</dt>
                                                            <dd class="col-sm-7" data-field="purpose"></dd>
        
                                                            <dt class="col-sm-5">Requested vehicle</dt>
                                                            <dd class="col-sm-7" data-field="vehicle_type"></dd>
        
                                                            <dt class="col-sm-5">Start date and Time</dt>
                                                            <dd class="col-sm-7" data-field="start_date"></dd>
        
                                                            <dt class="col-sm-5">Return date and Time</dt>
                                                            <dd class="col-sm-7" data-field="end_date"></dd>
        
                                                            <dt class="col-sm-5">Location From and To</dt>
                                                            <dd class="col-sm-7" data-field="start_location"></dd>
        
                                                            <dt class="col-sm-5">Passengers</dt>
                                                            <dd class="col-sm-7" data-field="passengers"></dd>
        
                                                            <dt class="col-sm-5">Materials</dt>
                                                            <dd class="col-sm-7" data-field="materials"></dd>
        
                                                            <dt class="col-sm-5">Progress</dt>
                                                            <dd class="col-sm-7" data-field="progress"></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end show modal -->
        
                                        <!-- Accept Alert Modal -->
                                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('ClusterDirector_approve_request') }}">
                                                        @csrf
                                                        <input type="hidden" name="request_id" id="request_id">
                                                        <div class="modal-body p-4">
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-warning"></i>
                                                                <h4 class="mt-2">Warning</h4>
                                                                <h5 class="mt-3">
                                                                    Are you sure you want to accept this request?</br> This action
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
        
                                        <!-- this is for the assign  modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Reject reason
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div> <!-- end modal header -->
                                                    <form method="POST" action="{{ route('ClusterDirector_reject_request') }}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="col-lg-6">
                                                                <h5 class="mb-3"></h5>
                                                                <div class="form-floating">
                                                                    <input type="hidden" name="request_id"
                                                                        id="Reject_request_id">
                                                                    <textarea class="form-control" name="reason" style="height: 60px;" required></textarea>
                                                                    <label for="floatingTextarea">Reason</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div> <!-- end modal footer -->
                                                    </form>
                                                </div> <!-- end modal content-->
                                            </div> <!-- end modal dialog-->
                                        </div>
                                        <!-- end assign modal -->
        
                                    </div>
                                    <!-- end .table-responsive-->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
        
        
            <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        
            <script>
                var table = $('.cluster_director_datatable').DataTable({
                    processing: true,
                    pageLength: 5,
                    serverSide: true,
                    ajax: {
                            url: "{{ route('FetchForDirector') }}",
                            data: function (d) {
                                d.customDataValue = 1;
                            }
                        },         
               columns: [{
                            data: 'counter',
                            name: 'counter'
                        },
                        {
                            data: 'requested_by',
                            name: 'requested_by'
                        },
                        {
                            data: 'vehicle_type',
                            name: 'vehicle_type'
                        },
                        {
                            data: 'start_location',
                            name: 'start_location'
                        },
                        {
                            data: 'end_location',
                            name: 'end_location'
                        },
                        {
                            data: 'date',
                            name: 'date'
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
        
        
                $('#standard-modal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var modal = $(this); // The modal
        
                    // Populate basic request details
                    modal.find('.modal-title').text('Request Details');
                    modal.find('[data-field="purpose"]').text(button.data('purpose'));
                    modal.find('[data-field="vehicle_type"]').text(button.data('vehicle_type'));
                    modal.find('[data-field="start_date"]').text(button.data('start_date') + ', ' + button.data(
                        'start_time'));
                    modal.find('[data-field="end_date"]').text(button.data('end_date') + ', ' + button.data('end_time'));
                    modal.find('[data-field="start_location"]').text(button.data('start_location'));
                    modal.find('[data-field="end_locations"]').text(button.data('end_locations'));
        
                    // Populate passengers
                    var passengers = button.data('passengers');
                    var passengerList = '';
                    if (passengers) {
                        passengers.forEach(function(person) {
                            passengerList += person.user.first_name + '<br>';
                        });
                    }
                    modal.find('[data-field="passengers"]').html(passengerList);
        
                    // Populate materials
                    var materials = button.data('materials');
                    var materialList = '';
                    if (materials) {
                        materials.forEach(function(material) {
                            materialList += 'Material name: ' + material.material_name + ',<br>' +
                                'Material Weight: ' + material.weight + '.<br>';
                        });
                    }
                    modal.find('[data-field="materials"]').html(materialList);
        
                    // Function to build progress messages
                    function buildProgressMessage(button) {
                        let progressMessages = [];
        
                        const messages = [{
                                condition: button.data('dir_approved_by'),
                                message: 'Approved by Director'
                            },
                            {
                                condition: button.data('director_reject_reason'),
                                message: 'Rejected by Director'
                            },
                            {
                                condition: button.data('div_approved_by'),
                                message: 'Approved by Division-Director'
                            },
                            {
                                condition: button.data('cluster_director_reject_reason'),
                                message: 'Rejected by Division-Director'
                            },
                            {
                                condition: button.data('hr_div_approved_by'),
                                message: 'Approved by HR-Director'
                            },
                            {
                                condition: button.data('hr_director_reject_reason'),
                                message: 'Rejected by HR-Director'
                            },
                            {
                                condition: button.data('transport_director_id'),
                                message: 'Approved by Dispatcher-Director'
                            },
                            {
                                condition: button.data('vec_director_reject_reason'),
                                message: 'Rejected by Dispatcher-Director'
                            },
                            {
                                condition: button.data('assigned_by'),
                                message: 'Approved by Dispatcher'
                            },
                            {
                                condition: button.data('assigned_by_reject_reason'),
                                message: 'Rejected by Dispatcher'
                            },
                            {
                                condition: button.data('vehicle_id'),
                                message: 'Assigned Vehicle <u>' + button.data('vehicle_plate') + '</u>'
                            },
                            {
                                condition: button.data('start_km'),
                                message: 'Vehicle Request <u>' + button.data('vehicle_plate') + '</u> Dispatched'
                            },
                            {
                                condition: button.data('end_km'),
                                message: 'Request completed'
                            },
                        ];
                        messages.forEach(item => {
                            if (item.condition) {
                                progressMessages.push(item.message);
                            }
                        });
        
                        // If no conditions were met, set progress to 'Pending'
                        let progress = progressMessages.length > 0 ? progressMessages.join('<br>') : 'Pending';
        
        
        
                        return progress;
                    }
        
                    // Populate progress
                    modal.find('[data-field="progress"]').html(buildProgressMessage(button));
        
                });
        
                $(document).ready(function() {
                    var AcceptedId;
        
                    $(document).on('click', '.accept-btn', function() {
                        AcceptedId = $(this).data('id');
        
                        $('#request_id').val(AcceptedId);
                        $('#confirmationModal').modal('show');
                    });
                });
        
                $(document).ready(function() {
                    var RejectedId;
        
                    $(document).on('click', '.reject-btn', function() {
                        RejectedId = $(this).data('id');
        
                        $('#Reject_request_id').val(RejectedId);
                        $('#staticBackdrop').modal('toggle');
                    });
                });
            </script>
        
            <!-- App js -->
            <script src="{{ asset('assets/js/app.min.js') }}"></script>
        @endsection
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        