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
            <div class="container-fluid">

                <div class="row">
                  
                 

                                    

            <div class="col-lg-12 mb-3">
                <form action="{{ route('attendancereport.filter') }}" method="Get">
                 
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    {{-- <form action="{{ route('dailyreport.filterReport') }}" method="GET"> --}}
                                    <!-- Plate Number Filter -->
                                    <div class="col-lg-4">
                                        <label for="selectPlateNumber" class="form-label">Vehicle Type</label>
                                        <select id="selectPlateNumber" name="vehicle_type" class="form-select" required>
                                            <option value="">Select Type</option>
                                            <option value="40/60">45/60 vehicle</option>
                                            <option value="whole_day">Whole day Minibus</option>
                                            <option value="position">Position Vehicle</option>
                                            <option value="morning_afternoon_minibus">Morning Afternoon Minibus</option>
                                        </select>
                                    </div>
                                
                                    <!-- Date Range Picker -->
                                    <div class="col-lg-2">
                                        <label for="daterangetime" class="form-label">Date Range: &nbsp;&nbsp;&nbsp;&nbsp; From</label>
                                        <input type="text" class="form-control date" id="startdate" name="start_date">
                                        <script>
                                            $('#startdate').calendarsPicker({
                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                pickerClass: 'myPicker',
                                                dateFormat: 'yyyy-mm-dd'
                                            });
                                        </script>
                                    </div>
                                    <div class="col-lg-2 ">
                                        <label for="daterangetime" class="form-label">To</label>
                                        <input type="text" class="form-control date" id="end_date" name="end_date">
                                        <script>
                                            $('#end_date').calendarsPicker({
                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                pickerClass: 'myPicker',
                                                dateFormat: 'yyyy-mm-dd'
                                            });
                                        </script>
                                    </div>
                                  
                                 <div class="col-lg-4 mt-3">
                                    <button type="submit" class="btn btn-info">Filter <i
                                        class="ri-arrow-right-line ms-1"></i></button>
                                
                                        <button type="submit" class="btn btn-success" onclick="document.getElementById('export').value=1">Export</button>
                                        <input type="hidden" id="export" name="export" value="0">
                                </div>
                            </div> 
                            </form>
                            </div>

                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Plate Number</th>
                                                <th>Type</th>
                                                <th>Date From - To</th>
                                                <th>Route</th>
                                                <th>Total Days</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @foreach($vehicles as $vehicle)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $vehicle->plate_number  }}</td>
                                                    <td>{{ $vehicle->rental_type  }}</td>
                                                    <td>{{$vehicle->interval ?? 'N/A'}}</td>
                                                    <td>
                                                        @php
                                                            $route = $routes->where('vehicle_id', $vehicle->vehicle_id)->first();
                                                            echo $route ? $route->route_name : 'N/A';
                                                        @endphp
                                                    </td>
                                                    <td>{{$vehicle->total ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div> <!-- end row-->
            </div> <!-- content -->

    <script  src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script>
        var table = $('.daily_report_datatable').DataTable({
            processing: true,
            pageLength: 3,
            serverSide: true,
            ajax: "{{ route('FetchDailyReport') }}",
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

    </script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <script src="assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

    <!-- Wizard Form Demo js -->
    <script src="assets/js/pages/form-wizard.init.js"></script>
    <script>
        src = "{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" 
    </script>

@endsection
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
