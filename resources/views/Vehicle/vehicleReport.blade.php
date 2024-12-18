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
                                        <li class="breadcrumb-item active">Vehicles Report</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Vehicles Report</h4>
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
                                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Filter Vehicles</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <form action="{{ route('dailyreport.filterVehicleReport') }}" method="GET">

                                                <div class="">

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            </br>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <input type="hidden" name="filter" value="Vehicle_filter">
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
                                                            <label for="selectVehicleType"
                                                                class="form-label">Vehicle Type</label>
                                                            <select id="selectVehicleType" name="vehicle_type"
                                                                class="form-select">
                                                                <option value="">VehicleType</option>
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->vehicle_type }}">
                                                                        {{ $vehicle->vehicle_type }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <label for="selectVehicleCategory" class="form-label">Vehicle Categories</label>
                                                            <select id="selectVehicleCategory" name="vehicle_category" class="form-select">
                                                                <option value="">VehicleCategory</option>
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->vehicle_category }}">
                                                                        {{ $vehicle->vehicle_category }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <label for="selectStatus" class="form-label">Vehicle Status</label>
                                                            <select id="selectStatus" name="status" class="form-select">
                                                                <option value="">Status</option>
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->status }}">
                                                                        {{ $vehicle->status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

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
                                    <h4 class="header-title"> Vehicles Report</h4>
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
                                                <th>Plate Number</th>
                                                <th>Vin</th>
                                                <th>Driver</th>
                                                <th>Model</th>
                                                <th>Year</th>
                                                <th>Owner</th>
                                                <th>Services</th>
                                                <th>Requested By</th>
                                                <th>Fuel Amount</th>
                                                <th>Mileage</th>
                                                <th>Last Service</th>
                                                <th>Next Service</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($vehicles as $km)
                                                <tr>
                                                    <td>{{ $km->plate_number }}</td>
                                                    <td>{{ $km->vin }}</td>
                                                    <td>{{ $km->driver }}</td>
                                                    <td>{{ $km->model }}</td>
                                                    <td>{{ $km->year }}</td>
                                                    <td>{{ $km->vehicle_type }}</td>
                                                    <td>{{ $km->vehicle_category }}</td>
                                                    <td>{{ $km->requested_by }}</td>
                                                    <td>{{ $km->fuel_amount }}</td>
                                                    <td>{{ $km->mileage }}</td>
                                                    <td>{{ $km->last_service }}</td>
                                                    <td>{{ $km->next_service }}</td>
                                                    <td>{{ $km->status }}</td>
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
