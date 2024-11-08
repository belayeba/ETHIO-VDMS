@extends('layouts.navigation')

@section('content')
    <div class="wrapper">
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Temporary Vehicle Request Report</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Temporary Vehicle Request Report</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="box_header common_table_header">
                                                <div class="main-title d-md-flex">
                                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Filter Report</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-3">
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
                                                        <div class="col-lg-4">
                                                            <label for="selectPlateNumber" class="form-label">Plate
                                                                Number</label>
                                                            <select id="selectPlateNumber" name="plate_number"
                                                                class="form-select">
                                                                <option value="">Select Plate Number</option>
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->plate_number }}">
                                                                        {{ $vehicle->plate_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <label for="selectName" class="form-label">Name</label>
                                                            <select id="selectName" name="driver_name" class="form-select">
                                                                <option value="">Select Driver</option>
                                                                @foreach ($drivers as $driver)
                                                                    <option value="{{ $driver->username }}">
                                                                        {{ $driver->username }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <label for="selectDepartment"
                                                                class="form-label">Departments</label>
                                                            <select id="selectDepartment" name="department"
                                                                class="form-select">
                                                                <option value="">Department</option>
                                                                @foreach ($departments as $department)
                                                                    <option value="{{ $department->department_id }}">
                                                                        {{ $department->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <label for="selectCluster" class="form-label">Clusters</label>
                                                            <select id="selectCluster" name="cluster" class="form-select">
                                                                <option value="">Cluster</option>
                                                                @foreach ($clusters as $cluster)
                                                                    <option value="{{ $cluster->cluster_id }}">
                                                                        {{ $cluster->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Date Range Picker -->
                                                        <div class="col-lg-4 z-3">
                                                            <label for="daterangetime" class="form-label">Date Range</label>
                                                            <input type="text" class="form-control date" id="datepicker"
                                                                name="date_range" data-toggle="date-picker"
                                                                data-time-picker="true"
                                                                data-locale='{"format": "DD/MM hh:mm A"}'>
                                                        </div>

                                                        {{-- <input id="datepicker"/> --}}
                                                        <script>
                                                            const picker = new easepick.create({
                                                                element: document.getElementById('datepicker'),
                                                                css: [
                                                                    'https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.css',
                                                                    'https://cdn.jsdelivr.net/npm/@easepick/range-plugin@1.2.1/dist/index.css',
                                                                ],
                                                                plugins: ['RangePlugin'],
                                                                RangePlugin: {
                                                                    tooltip: true,
                                                                },
                                                            });
                                                        </script>

                                                        {{-- <div class="col-md-3">
                                                <div class="position-relative">
                                                    <label for="driving-license" class="form-label">Date</label>
                                                    <input id="fill_date" name="Driving_license" class="form-control" placeholder="When" type="text">
                                                </div>
                                            </div>
                                             <script> 
                                                $('#fill_date').calendarsPicker({ 
                                                    calendar: $.calendars.instance('ethiopian', 'am'), 
                                                    pickerClass: 'myPicker', 
                                                    dateFormat: 'yyyy-mm-dd' 
                                                });
                                             </script> --}}

                                                        <div class="col-lg-4 mt-3">
                                                            <button type="submit" class="btn btn-info">Filter <i
                                                                    class="ri-arrow-right-line ms-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mt-3">
                                                        <!-- Set export to 1 when exporting -->
                                                        <button type="submit" class="btn btn-success" onclick="document.getElementById('export').value=1">Export</button>
                                                        <input type="hidden" id="export" name="export" value="0">
                                                    </div>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Temporary Vehicle Request Report</h4>
                                    <p class="text-muted mb-0">
                                        The Buttons extension for DataTables provides a common set of options, API
                                        methods and styling to display buttons on a page
                                        that will interact with a DataTable.
                                    </p>
                                </div>

                                <div class="card-body">
                                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Requested By</th>
                                                <th>Vehicle Type</th>
                                                <th>Plate Number</th>
                                                <th>Purpose</th>
                                                <th>Start Date</th>
                                                <th>Start Time</th>
                                                <th>End Date</th>
                                                <th>End Time</th>
                                                <th>In/Out Town</th>
                                                <th>How many Days</th>
                                                <th>Start KM</th>
                                                <th>End KM</th>
                                                <th>With/Without Driver</th>
                                                <th>Start Location</th>
                                                <th>End Location</th>
                                                <th>Departmen</th>
                                                <th>Cluster</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($dailkms as $km)
                                                <tr>
                                                    <td>{{ $km->requested_by }}</td>
                                                    <td>{{ $km->vehicle_type }}</td>
                                                    <td>{{ $km->plate_number }}</td>
                                                    <td>{{ $km->purpose }}</td>
                                                    <td>{{ $km->start_date }}</td>
                                                    <td>{{ $km->start_time }}</td>
                                                    <td>{{ $km->end_date }}</td>
                                                    <td>{{ $km->end_time }}</td>
                                                    <td>{{ $km->in_out_of_addis_ababa }}</td>
                                                    <td>{{ $km->how_many_days }}</td>
                                                    <td>{{ $km->start_km }}</td>
                                                    <td>{{ $km->end_km }}</td>
                                                    <td>{{ $km->with_driver }}</td>
                                                    <td>{{ $km->start_location }}</td>
                                                    <td>{{ $km->end_locations }}</td>
                                                    <td>{{ $km->department_name }}</td>
                                                    <td>{{ $km->cluster_name }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->


                </div> <!-- content -->

            </div>

        </div>
    @endsection
