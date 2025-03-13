@extends('layouts.navigation')

@section('content')
<div class="content-page">
    <div class="content">

        @if (Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5"
            role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                aria-label="Close"></button>
            <strong>Error - </strong> {!! session('error_message') !!}
        </div>
        @endif

        @if (Session::has('success_message'))
        <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5"
            role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                aria-label="Close"></button>
            <strong> Success- </strong> {!! session('success_message') !!}
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <form action="{{ route('dailyreport.filterTemporaryReport') }}" method="GET">

                            <div class="">

                                <div class="row">
                                    <div class="col-lg-12">
                                        </br>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" name="filter" value="permanent_filter">
                                    <!-- Plate Number Filter -->
                                    <div class="col-lg-2">
                                        <label for="selectPlateNumber" class="form-label">@lang('messages.Plate Number')</label>
                                        <select id="selectPlateNumber" name="plate_number"
                                            class="form-select">
                                            <option value="">Select Plate Number</option>
                                            @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->plate_number }}">
                                                {{ $vehicle->plate_number }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="selectName" class="form-label">@lang('messages.Name')</label>
                                        <select id="selectName" name="driver_name" class="form-select">
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                            <option value="{{ $driver->username }}">
                                                {{ $driver->username }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="selectDepartment"
                                            class="form-label">@lang('messages.Department')</label>
                                        <select id="selectDepartment" name="department"
                                            class="form-select">
                                            <option value="">Department</option>
                                            @foreach ($departments as $department)
                                            <option value="{{ $department->department_id }}">
                                                {{ $department->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="selectCluster" class="form-label">@lang('messages.Cluster')</label>
                                        <select id="selectCluster" name="cluster" class="form-select">
                                            <option value="">Cluster</option>
                                            @foreach ($clusters as $cluster)
                                            <option value="{{ $cluster->cluster_id }}">
                                                {{ $cluster->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Date Range Picker -->
                                    <div class="col-lg-1 z-3">
                                        <label for="daterangetime" class="form-label">@lang('messages.Date Range')</label>
                                        <input type="text" class="form-control date" id="start_date"
                                            name="start_date">
                                        <script>
                                            $('#start_date').calendarsPicker({
                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                pickerClass: 'myPicker',
                                                dateFormat: 'yyyy-mm-dd'
                                            });
                                        </script>
                                    </div>

                                    <div class="col-lg-1 z-3">
                                        <label for="daterangetime" class="form-label">@lang('messages.Date Range')</label>
                                        <input type="text" class="form-control date" id="end_date"
                                            name="end_date">
                                        <script>
                                            $('#end_date').calendarsPicker({
                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                pickerClass: 'myPicker',
                                                dateFormat: 'yyyy-mm-dd'
                                            });
                                        </script>
                                    </div>

                                    <div class="col-lg-2 mt-3">
                                        <button type="submit" class="btn btn-info">@lang('messages.Filter') <i
                                                class="ri-arrow-right-line ms-1"></i></button>
                                        <button type="submit" class="btn btn-success" onclick="document.getElementById('export').value=1">@lang('messages.Export')</button>
                                        <input type="hidden" id="export" name="export" value="0">
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <!-- Set export to 1 when exporting -->

                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100  temp_report_datatable">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Requestor') }}</th>
                                        <th>{{ __('messages.Plate Number') }}</th>
                                        <th>{{ __('messages.Start KM') }}</th>
                                        <th>{{ __('messages.End KM') }}</th>
                                        <th>KM Difference</th>
                                        <th>{{ __('messages.Start Location') }}</th>
                                        <th>{{ __('messages.End Location') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                                <div class="modal fade" id="viewModal" role="dialog" tabindex="-1"
                                    aria-labelledby="viewModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Temporary Report Detail</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <!-- First Column -->
                                                    <div class="col-md-6">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-4">@lang('messages.Requested By')</dt>
                                                            <dd class="col-sm-8" data-field="requested_by"></dd>

                                                            <dt class="col-sm-4">@lang('messages.Plate Number')</dt>
                                                            <dd class="col-sm-8" data-field="plate_number"></dd>

                                                            <dt class="col-sm-4">@lang('messages.Purpose')</dt>
                                                            <dd class="col-sm-8" data-field="purpose"></dd>

                                                            <dt class="col-sm-4">@lang('messages.Start Date')</dt>
                                                            <dd class="col-sm-8" data-field="start_date"></dd>

                                                            <dt class="col-sm-4">@lang('messages.Start Time')</dt>
                                                            <dd class="col-sm-8" data-field="start_time"></dd>

                                                            <dt class="col-sm-4">@lang('messages.End Date')</dt>
                                                            <dd class="col-sm-8"
                                                                data-field="end_date"></dd>

                                                            <dt class="col-sm-4">@lang('messages.End Time')</dt>
                                                            <dd class="col-sm-8" data-field="end_time">
                                                            </dd>

                                                            <dt class="col-sm-4">@lang('messages.In/Out Town')</dt>
                                                            <dd class="col-sm-8" data-field="in_out_of_addis_ababa">
                                                            </dd>


                                                        </dl>
                                                    </div>

                                                    <!-- Second Column -->
                                                    <div class="col-md-6">
                                                        <dl class="row mb-0">

                                                            <dt class="col-sm-4">@lang('messages.Duration')</dt>
                                                            <dd class="col-sm-8" data-field="how_many_days"></dd>

                                                            <dt class="col-sm-4">@lang('messages.Start KM')</dt>
                                                            <dd class="col-sm-8" data-field="start_km"></dd>

                                                            <dt class="col-sm-4">@lang('messages.End KM')</dt>
                                                            <dd class="col-sm-8" data-field="end_km"></dd>

                                                            <dt class="col-sm-4">@lang('messages.Start Location')</dt>
                                                            <dd class="col-sm-8" data-field="start_location"></dd>

                                                            <dt class="col-sm-4">@lang('messages.End Location')</dt>
                                                            <dd class="col-sm-8" data-field="end_locations">

                                                            <dt class="col-sm-4">@lang('messages.Department')</dt>
                                                            <dd class="col-sm-8" data-field="department_name"></dd>

                                                            <dt class="col-sm-4">@lang('messages.Cluster')</dt>
                                                            <dd class="col-sm-8" data-field="cluster_name">
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">@lang('Close')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </table>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div> <!-- end row-->
    </div> <!-- content -->

    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(function() {
            var table = $('.temp_report_datatable').DataTable({
                pageLength: 5,
                ajax: "{{ route('tempreport.list') }}",
                columns: [{
                        data: 'requested_by',
                        name: 'requested_by'
                    }, // update if needed
                    {
                        data: 'plate_number',
                        name: 'plate_number'
                    }, // update if needed
                    {
                        data: 'start_km',
                        name: 'start_km'
                    }, // corrected key
                    {
                        data: 'end_km',
                        name: 'end_km'
                    }, // corrected key
                    {
                        data: 'difference',
                        name: 'difference'
                    }, // corrected key
                    {
                        data: 'start_location',
                        name: 'start_location'
                    },
                    {
                        data: 'end_locations',
                        name: 'end_locations'
                    }, // note: key is "end_locations" in your JSON
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        });

        $(document).ready(function() {
            var RejectedId;

            $(document).on('click', '.reject-btn', function() {
                RejectedId = $(this).data('id');

                $('#deleted_vehicle_id').val(RejectedId);
                $('#confirmationModal').modal('toggle');
            });
        });
    </script>

    <script>
        $(document).on('click', '.view-btn', function() {
            // Retrieve data from the button's data attributes
            var requestedBy = $(this).data('requested_by');
            var plateNumber = $(this).data('plate_number');
            var purpose = $(this).data('purpose');
            var startDate = $(this).data('start_date');
            var startTime = $(this).data('start_time');
            var endDate = $(this).data('end_date');
            var endTime = $(this).data('end_time');
            var inOut = $(this).data('in_out_of_addis_ababa');
            var howManyDays = $(this).data('how_many_days');
            var startKm = $(this).data('start_km');
            var endKm = $(this).data('end_km');
            var startLocation = $(this).data('start_location');
            var endLocations = $(this).data('end_locations');
            var departmentName = $(this).data('department_name');
            var clusterName = $(this).data('cluster_name');

            // Populate modal fields based on data-field attribute in your modal
            $('[data-field="requested_by"]').text(requestedBy);
            $('[data-field="plate_number"]').text(plateNumber);
            $('[data-field="purpose"]').text(purpose);
            $('[data-field="start_date"]').text(startDate);
            $('[data-field="start_time"]').text(startTime);
            $('[data-field="end_date"]').text(endDate);
            $('[data-field="end_time"]').text(endTime);
            $('[data-field="in_out_of_addis_ababa"]').text(inOut);
            $('[data-field="how_many_days"]').text(howManyDays);
            $('[data-field="start_km"]').text(startKm);
            $('[data-field="end_km"]').text(endKm);
            $('[data-field="start_location"]').text(startLocation);
            $('[data-field="end_locations"]').text(endLocations);
            $('[data-field="department_name"]').text(departmentName);
            $('[data-field="cluster_name"]').text(clusterName);

            // Open the modal programmatically
            $('#viewModal').modal('show');
        });
    </script>

    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    @endsection
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>