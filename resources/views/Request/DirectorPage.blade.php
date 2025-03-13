@extends('layouts.navigation')
@section('content')
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
            <!-- <h4 class="header-title mb-4">DIRECTOR PAGE</h4> -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive" id="table1">
                                <table class="table director_datatable table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.Roll No.') }}</th>
                                            <th>{{ __('messages.Requested By') }}</th>
                                            <th>{{ __('messages.Vehicle Type') }}</th>
                                            <th>{{ __('messages.Requested At') }}</th>
                                            <th>{{ __('messages.Status') }}</th>
                                            <th>{{ __('messages.Action') }}</th>
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
                                                <h4 class="modal-title">@lang('messages.Request Details')</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-5">@lang('messages.Request reason')</dt>
                                                    <dd class="col-sm-7" data-field="purpose"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Requested vehicle')</dt>
                                                    <dd class="col-sm-7" data-field="vehicle_type"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Start date and Time')</dt>
                                                    <dd class="col-sm-7" data-field="start_date"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Return date and Time')</dt>
                                                    <dd class="col-sm-7" data-field="end_date"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Location From and To')</dt>
                                                    <dd class="col-sm-7" data-field="start_location"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Passengers')</dt>
                                                    <dd class="col-sm-7" data-field="passengers"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Materials')</dt>
                                                    <dd class="col-sm-7" data-field="materials"></dd>

                                                    <dt class="col-sm-5">Progress</dt>
                                                    <dd class="col-sm-7" data-field="progress"></dd>
                                                </dl>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">@lang('messages.Close')</button>
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
                                            <form method="POST" action="{{ route('director_approve_request') }}">
                                                @csrf
                                                <input type="hidden" name="request_id" id="request_id">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i class="ri-alert-line h1 text-warning"></i>
                                                        <h4 class="mt-2">@lang('messages.Warning')</h4>
                                                        <h5 class="mt-3">
                                                            @lang('messages.Are you sure you want to accept this request?')</br> @lang('messages.This action cannot be undone.')
                                                        </h5>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">@lang('messages.Cancel')</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="confirmDelete">@lang('messages.Yes, Accept')</button>
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
                                                <h5 class="modal-title" id="staticBackdropLabel">@lang('messages.Reject reason')
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div> <!-- end modal header -->
                                            <form method="POST" action="{{ route('director_reject_request') }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-lg-6">
                                                        <h5 class="mb-3"></h5>
                                                        <div class="form-floating">
                                                            <input type="hidden" name="request_id"
                                                                id="Reject_request_id">
                                                            <textarea class="form-control" name="reason" style="height: 60px;" required></textarea>
                                                            <label for="floatingTextarea">@lang('messages.Reason')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                    <button type="submit" class="btn btn-danger">@lang('messages.Reject')</button>
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
        var table = $('.director_datatable').DataTable({
            processing: true,
            pageLength: 5,
            serverSide: true,
            ajax: "{{ route('FetchForDirector') }}",
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
                    passengerList += person.user.first_name + ' ' + person.user.middle_name  + '<br>';
                });
            }
            modal.find('[data-field="passengers"]').html(passengerList);

            // Populate materials
            var materials = button.data('materials');
            var materialList = '';
            if (materials) {
                materials.forEach(function(material) {
                    materialList +=  material.material_name + ' ' + material.weight + '.<br>';
                });
            }
            modal.find('[data-field="materials"]').html(materialList);
            modal.find('[data-field="materials"]').html(materialList);

            // Function to build progress messages
            function buildProgressMessage(button) {
                let progressMessages = [];

                const messages = [
                    {
                        condition: button.data('dir_approved_by') && !button.data('director_reject_reason'),
                        message: '<span style="color: green;">'+ button.data('dir_approved_by')+' (Director)'+'</span>'
                    },
                    {
                        condition: button.data('director_reject_reason') && button.data('dir_approved_by'),
                        message: '<span style="color: red;">Rejected By '+ button.data('dir_approved_by')+'(Director)</span>'
                    },
                    {
                        condition: button.data('div_approved_by') && !button.data('cluster_director_reject_reason'),
                        message: '<span style="color: green;">' + button.data('div_approved_by') + ' (Division)' +  '</span>'
                    },
                    {
                        condition: button.data('cluster_director_reject_reason') && button.data('div_approved_by'),
                        message: '<span style="color: red;">Rejected by ' +button.data('div_approved_by') +' (Division)' +  '</span>'
                    },
                    {
                        condition: button.data('hr_div_approved_by') && !button.data('hr_director_reject_reason'),
                        message: '<span style="color: green;">' + button.data('hr_div_approved_by') + ' (Division)</span>'
                    },
                    {
                        condition: button.data('hr_director_reject_reason') && button.data('hr_div_approved_by'),
                        message: '<span style="color: red;">Rejected by '+ button.data('hr_div_approved_by') + ' ( Division)</span>'
                    },
                    {
                        condition: button.data('transport_director_id') && !button.data('vec_director_reject_reason'),
                        message: '<span style="color: green;">'+button.data('transport_director_id')+' (Transport_Dir)</span>',
                    },
                    {
                        condition: button.data('vec_director_reject_reason') && button.data('transport_director_id'),
                        message: '<span style="color: red;">Rejected by '+button.data('transport_director_id')+' ( Transport_Dir)</span>',
                    },
                    {
                        condition: button.data('assigned_by') && !button.data('assigned_by_reject_reason'),
                        message: '<span style="color: green;">'+ button.data('assigned_by') +' (Dispatcher)</span>'
                    },
                    {
                        condition: button.data('assigned_by_reject_reason') && button.data('assigned_by'),
                        message: '<span style="color: red;">Rejected by '+ button.data('assigned_by') + ' (Dispatcher)</span>'
                    },
                    {
                        condition: button.data('vehicle_id'),
                        message: '<span style="color: green;">Assigned Vehicle <u>' + button.data('vehicle_plate') + '</u></span>'
                    },
                    {
                        condition: button.data('start_km'),
                        message: '<span style="color: green;">Vehicle Request <u>' + button.data('vehicle_plate') + '</u> Dispatched</span>'
                    },
                    {
                        condition: button.data('end_km'),
                        message: '<span style="color: green;">Request completed</span>'
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
