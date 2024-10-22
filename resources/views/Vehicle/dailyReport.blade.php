@extends('layouts.navigation')

@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Daily km Report</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Daily km Report</h4>
                            </div>
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
                                        <form action="{{ route('vehicle.filterReport') }}" method="GET">

                                        <div class="">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    </br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form action="{{ route('vehicle.filterReport') }}" method="GET">
                                                <!-- Plate Number Filter -->
                                                <div class="col-lg-4">
                                                    <label for="selectPlateNumber" class="form-label">Plate Number</label>
                                                    <select id="selectPlateNumber" name="plate_number" class="form-select">
                                                        <option value="">Select Plate Number</option>
                                                        @foreach($vehicles as $vehicle)
                                                            <option value="{{ $vehicle->plate_number }}">{{ $vehicle->plate_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <!-- Driver Name Filter -->
                                                <div class="col-lg-4">
                                                    <label for="selectName" class="form-label">Name</label>
                                                    <select id="selectName" name="driver_name" class="form-select">
                                                        <option value="">Select Driver</option>
                                                        @foreach($drivers as $driver)
                                                            <option value="{{ $driver->driver_id }}">{{ $driver->users->username }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <!-- Department Filter -->
                                                <div class="col-lg-4">
                                                    <label for="selectDepartment" class="form-label">Department</label>
                                                    <select id="selectDepartment" name="department" class="form-select">
                                                        <option value="">Select Department</option>
                                                        @foreach($departments as $department)
                                                            <option value="{{ $department->department_id }}">{{ $department->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <!-- Date Range Picker -->
                                                <div class="col-lg-4 mt-3">
                                                    <label for="daterangetime" class="form-label">Date Range Pick With Times</label>
                                                    <input type="text" class="form-control date" id="daterangetime" name="date_range" data-toggle="date-picker" data-time-picker="true" data-locale='{"format": "DD/MM hh:mm A"}'>
                                                </div>
                                            </div>
                                            
                                            <!-- Filter Button -->
                                            <div class="row mt-3">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn btn-info">Filter <i class="ri-arrow-right-line ms-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </from>
                                    <input type="text" name="datetimes" />                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Daily km Report</h4>
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
                                            <th>Date</th>
                                            <th>Plate Number</th>
                                            <th>Morning KM</th>
                                            <th>Night KM</th>
                                            <th>Daily KM Difference </th>

                                        </tr>
                                    </thead>


                                    <tbody>
                                        @foreach($dailkms as $km)
                                            <tr>
                                                <td>{{ $km->date }}</td>
                                                <td>{{ $km->vehicle->plate_number ?? 'N/A' }}</td>
                                                <td>{{ $km->morning_km }}</td>
                                                <td>{{ $km->afternoon_km }}</td>
                                                <td>{{ $km->afternoon_km - $km->morning_km }}</td>
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
    <script>
        $(function() {
      $('input[name="datetimes"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
          format: 'M/DD hh:mm A'
        }
      });
    });
        // $(document).ready(function() {
        //     $('#daterangetime').daterangepicker({
        //         timePicker: true,
        //         timePicker24Hour: false,
        //         locale: {
        //             format: 'DD/MM hh:mm A'
        //         }
        //     });
        // });
    </script>
@endsection

