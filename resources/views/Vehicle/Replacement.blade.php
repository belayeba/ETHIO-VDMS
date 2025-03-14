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

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Form Section -->
                    <div class="col-12 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Replace Permanent Vehicle</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('Replacement.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div id="progressbarwizard">
                                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                            <li class="nav-item">
                                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Replace</span>
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
                                                        <label class="form-label" for="validationTooltip02">Select old vehicle</label>
                                                        <select class="form-control" id="vehicleSelect" name="permanent_id">
                                                            <option value="">Select old vehicle</option>
                                                            @foreach ($permanent as $perm)
                                                            <option value="{{$perm->vehicle_request_permanent_id}}">{{$perm->vehicle->plate_number}}</option>
                                                        @endforeach 
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="position-relative mb-3">
                                                        <label class="form-label" for="validationTooltip02">Select Replacement</label>
                                                        <select class="form-control" id="routeSelect" name="new_vehicle_id">
                                                            <option value="">Select Replacement</option>
                                                            @foreach ($vehicles as $vec)
                                                                <option value="{{$vec->vehicle_id}}">{{$vec->plate_number}}</option>
                                                            @endforeach 
                                                        </select>
                                                    </div>
                                                </div>

                                                <ul class="list-inline wizard mb-0">
                                                    <li class="next list-inline-item float-end">
                                                        <button type="submit" class="btn btn-info">@lang('messages.Submit')</button>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table attendance_datatable table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.Roll No.') }}</th>
                                                <th>Old Car</th>
                                                <th>New Car</th>
                                                <th>{{ __('messages.Requested By') }}</th>
                                                <th>{{ __('messages.Date') }}</th>
                                                <th>{{ __('messages.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Warning Alert Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form method="POST" id="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="request_id" id="Reject_attendance_id">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i class="ri-alert-line h1 text-warning"></i>
                                                        <h4 class="mt-2">@lang('messages.Warning')</h4>
                                                        <h5 class="mt-3">
                                                            @lang('messages.Are you sure you want to accept this request?')</br> @lang('messages.This action cannot be undone.')
                                                        </h5>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">@lang('messages.Cancel')</button>
                                                        <button type="submit" class="btn btn-danger"
                                                            id="confirmDelete">@lang('messages.Yes, Accept')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <!-- show all the information about the request modal -->
                                <div id="update-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Request Update
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form  method="post" id="update-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="position-relative mb-3">
                                                            <label class="form-label" for="validationTooltip02">Select old vehicle</label>
                                                            <select class="form-control"  name="permanent_id">
                                                                <option value=""  id="oldSelect"></option>
                                                                @foreach ($permanent as $perm)
                                                                <option value="{{$perm->vehicle_request_permanent_id}}">{{$perm->vehicle->plate_number}}</option>
                                                            @endforeach 
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="position-relative mb-3">
                                                            <label class="form-label" for="validationTooltip02">Select Replacement</label>
                                                            <select class="form-control"  name="new_vehicle_id">
                                                                <option value="" id="newSelect"></option>
                                                                @foreach ($vehicles as $vec)
                                                                    <option value="{{$vec->vehicle_id}}">{{$vec->plate_number}}</option>
                                                                @endforeach 
                                                            </select>
                                                        </div>
                                                    </div>
                                                    </div>                                                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                <button type="submit" class="btn btn-info">@lang('messages.Submit')</button>
                                            </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- end show modal -->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                </div>
            </div>

            


    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        var table = $('.attendance_datatable').DataTable({
            processing: true,
            pageLength: 5,
            serverSide: true,
            ajax: "{{ route('Replacement.fetch') }}",
            columns: [{
                    data: 'counter',
                    name: 'counter'
                },
                {
                    data: 'oldCar',
                    name: 'oldCar'
                },
               
                {
                    data: 'newCar',
                    name: 'newCar'
                },
                {
                    data: 'registerBy',
                    name: 'registerBy'
                },
                {
                    data: 'date',
                    name: 'date'
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
            var AcceptedId;
            var newCar;
            var oldCar;

            $(document).on('click', '.update-btn', function() {
                AcceptedId = $(this).data('id');
                newCar = $(this).data('new');
                oldCar = $(this).data('old');
                console.log(newCar, oldCar, AcceptedId)

                $('#update-form').attr('action', '{{ route('Replacement.update', ['id' => ':id']) }}'.replace(':id', AcceptedId));

                $('#request_update_id').val(AcceptedId);
                $('#newSelect').text(newCar);
                $('#oldSelect').text(oldCar);
                $('#update-modal').modal('show');
            });
        });

        $(document).ready(function() {
            var deletedId;

            $(document).on('click', '.reject-btn', function() {
                deletedId = $(this).data('id');

                $('#delete-form').attr('action', '{{ route('Replacement.delete', ['id' => ':id']) }}'.replace(':id', deletedId));

                $('#Reject_attendance_id').val(deletedId);
                $('#confirmationModal').modal('toggle');
            });
        });
    </script>

   <!-- App js -->
   <script src="{{ asset('assets/js/app.min.js') }}"></script>
   @endsection
   <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
