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
                    {{-- <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Vehicles Report</h4>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="row">
                        <div class="col-12">
                            
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title"> Vehicles Report</h4>
                                </div>

                                <div class="card-body">
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
                                                        <label for="selectVehicleType" class="form-label">Vehicle Type</label>
                                                        <select id="selectVehicleType" name="vehicle_type" class="form-select">
                                                            <option value="">Select Vehicle Type</option>
                                                            <option value="other">Rental</option>
                                                            <option value="Organizational">Organizational</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="selectStatus" class="form-label">Vehicle Status</label>
                                                        <select id="selectStatus" name="status" class="form-select">
                                                            <option value="">Select Status</option>
                                                            <option value="Active">Active</option>
                                                            <option value="Not Available">Not Available</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-lg-4" id="rentalTypeDiv">
                                                        {{-- <div class="col-md-9"> --}}
                                                            <label class="col-md-3 col-form-label" for="rental_type">Rental Type</label>
                                                            <select id="rentalType" name="rental_type" class="form-select">
                                                                <option value="">Select Type</option>
                                                                <option value="whole_day">Whole Day</option>
                                                                <option value="position">Position</option>
                                                                <option value="40/60">45/60</option>
                                                                <option value="morning_afternoon_minibus">Morning Afternoon Minibus</option>
                                                            </select>
                                                        {{-- </div> --}}
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

                                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Plate Number</th>
                                                <th>Chassis</th>
                                                <th>Driver</th>
                                                <th>Owner</th>
                                                <th>Services Type</th>
                                                <th>Rental Type</th>
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
                                                    <td>{{ $km->vehicle_type }}</td>
                                                    <td>{{ $km->vehicle_category }}</td>
                                                    <td>{{ $km->requested_by }}</td>
                                                    <td>{{ $km->rental_type }}</td>
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
        {{-- <script>
            function toggleRentalType() {
                const vehicleType = document.getElementById('selectVehicleType').value;
                const rentalTypeDiv = document.getElementById('rentalTypeDiv');
        
                if (vehicleType === 'other') {
                    rentalTypeDiv.style.display = 'block';
                } else {
                    rentalTypeDiv.style.display = 'none';
                }
            }
        </script> --}}
    @endsection