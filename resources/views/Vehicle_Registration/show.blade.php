@extends('layouts.navigation')
@section('content')
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->


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
                <!-- Start Content-->
            <section class="admin-visitor-area up_st_admin_visitor">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title mb-0">@lang('messages.Vehicle Registration')</h4>
                                </div>

                                <div class="card-body">
                                    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
                                    @csrf

                                    <div id="progressbarwizard">
                                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                            <li class="nav-item">
                                                <a href="#first" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">@lang('messages.Basic')</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" data-target-form="#profileForm">
                                                <a href="#second" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">@lang('messages.Profile')</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" data-target-form="#otherForm">
                                                <a href="#third" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i
                                                        class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">@lang('messages.Type')</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content mb-0 b-0">
                                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                                <div
                                                    class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="first">
                                                <form method="POST" action="{{ route('vehicleRegistration.store') }}"
                                                    accept-charset="UTF-8" name="ebook-form" id="ebook-form"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="Chancy Number">@lang('messages.Chancy Number')</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" class="form-control"
                                                                        id="Chancy Number"
                                                                        placeholder="Enter the Chancy number"
                                                                        name="vin" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label" for="make">
                                                                    Make</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" id="Make" name="make"
                                                                        placeholder="Enter the make"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="model">@lang('messages.Model')</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" id="Model" name="model"
                                                                        placeholder="Enter the model"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="year">@lang('messages.Year')</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" id="Year" name="year"
                                                                        placeholder="Enter the year"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="plate_number">@lang('messages.Plate Number')</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" id="Plate Number"
                                                                        name="plate_number"
                                                                        pattern="^[A-Z]{2}-\d{1}-\d{5}$"
                                                                        placeholder="AA-1-12345" class="form-control"
                                                                        required>
                                                                </div>
                                                            </div>

                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    <ul class="list-inline wizard mb-0">
                                                        <li class="next list-inline-item float-end">
                                                            <a href="#" class="btn btn-info"
                                                                id="nextBtn">@lang('messages.Next') <i
                                                                    class="ri-arrow-right-line ms-1"></i></a>
                                                        </li>
                                                    </ul>
                                            </div>

                                            <div class="tab-pane fade" id="second">
                                                <form id="profileForm" method="post" action="#"
                                                    class="form-horizontal">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="mileage">@lang('messages.Mileage')</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" id="Mileage"
                                                                        name="mileage" placeholder="Enter the mileage"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label" for="fuel_type">@lang('messages.Fuel Type')</label>
                                                                <div class="col-md-9">
                                                                    <select id="fuel_type" name="fuel_type" class="form-select" required>
                                                                        <option value="">Select Fuel Type</option>
                                                                        <option value="Benzene">Benzene</option>
                                                                        <option value="Diesel">Diesel</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row mb-3" id="fuel_amount_row">
                                                                <label class="col-md-3 col-form-label" for="fuel_amount">@lang('messages.Fuel Amount')</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" id="fuel_amount" name="fuel_amount" placeholder="Enter the fuel amount" class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="capacity">@lang('messages.Capacity')</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" id="capacity"
                                                                        name="capacity"
                                                                        placeholder="Enter the max Capacity"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="Last Service">@lang('messages.Last Service')</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" id="Last Service"
                                                                        name="Last_Service"
                                                                        placeholder="Enter the last service KM"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="Next Service">@lang('messages.Next Service')</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" id="Next Service"
                                                                        name="Next_Service"
                                                                        placeholder="Enter the next service KM"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="Notes">@lang('messages.Notes')</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" id="Notes"
                                                                        name="Notes"
                                                                        placeholder="Enter your notes here"
                                                                        class="form-control">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                    <!-- end row -->
                                                    <ul class="pager wizard mb-0 list-inline">
                                                        <li class="previous list-inline-item">
                                                            <button type="button" class="btn btn-light"><i
                                                                    class="ri-arrow-left-line me-1"></i>
                                                                @lang('messages.Back') </button>
                                                        </li>
                                                        <li class="next list-inline-item float-end">
                                                            <button type="button"
                                                                class="btn btn-info">@lang('messages.Next') <i
                                                                    class="ri-arrow-right-line ms-1"></i></button>
                                                        </li>
                                                    </ul>
                                            </div>

                                            <div class="tab-pane fade" id="third">
                                                <div class="row">
                                                    <div class="col-12">
                                                        {{-- <div class="row mb-3">
                                                            <label class="col-md-3 col-form-label"
                                                                for="driver">@lang('messages.Driver')</label>
                                                            <div class="col-md-9">
                                                                <select id="driver" name="driver"
                                                                    class="form-select">
                                                                    <option value="">Select Driver</option>
                                                                    @foreach ($drivers as $driver)
                                                                        <option value="{{ $driver->driver_id }}">
                                                                            {{ $driver->user->first_name . ' ' . $driver->user->middle_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div> --}}

                                                        <div class="row mb-3">
                                                            <label class="col-md-3 col-form-label"
                                                                for="position">Position</label>
                                                            <div class="col-md-9">
                                                                <select id="position" name="position"
                                                                    class="form-select" required>
                                                                    <option value="">Select Position</option>
                                                                    <option value="Other">Other</option>
                                                                    <option value="Position">Position</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-md-3 col-form-label"
                                                                for="vehicle_category">Service</label>
                                                            <div class="col-md-9">
                                                                <select id="vehicleCategory" name="vehicle_category"
                                                                    class="form-select" required>
                                                                    <option value="">Select Vehicle service
                                                                    </option>
                                                                    <option value="human">Human</option>
                                                                    <option value="load">Load</option>
                                                                    <option value="both">Both</option>
                                                                    <option value="position">Position</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-md-3 col-form-label"
                                                                for="Libre">@lang('messages.Libre')</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="Libre" name="libre"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-md-3 col-form-label"
                                                                for="Insurance">@lang('messages.Insurance')</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="Insurance" name="insurance"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-md-3 col-form-label"
                                                                for="vehicle_type">@lang('messages.Owner')</label>
                                                            <div class="col-md-9">
                                                                <select id="vehicleType" name="vehicle_type"
                                                                    class="form-select" required
                                                                    onchange="toggleFields()">
                                                                    <option value="">Select owner</option>
                                                                    <option value="Organizational">Organizational
                                                                    </option>
                                                                    <option value="Rental">Rental</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3" id="rentalDiv" style="display: none;">
                                                            <div class="col-md-9">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="rental_type">@lang('messages.Rental Type')</label>
                                                                <select id="rentalType" name="rental_type"
                                                                    class="form-select">
                                                                    <option value="">Select Type</option>
                                                                    <option value="whole_day">Whole Day</option>
                                                                    <option value="position">Position</option>
                                                                    <option value="40/60">45/60</option>
                                                                    <option value="morning_afternoon_minibus">Morning
                                                                        Afternoon Minibus</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                </div>
                                                <!-- end row -->
                                                <ul class="pager wizard mb-0 list-inline mt-1">
                                                    <li class="previous list-inline-item">
                                                        <button type="button" class="btn btn-light"><i
                                                                class="ri-arrow-left-line me-1"></i>@lang('messages.Back')</button>
                                                    </li>
                                                    <!-- Your form fields go here -->

                                                    <li class="next list-inline-item float-end">
                                                        <button type="submit"
                                                            class="btn btn-info">@lang('messages.Submit')</button>
                                                    </li>
                                                    </form>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title mb-0">@lang('messages.Vehicle List')</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="lms_table"
                                            class="table table-centered table-nowrap  vehicle_datatable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('messages.Plate Number') }}</th>
                                                    <th>{{ __('messages.Vehicle Type') }}</th>
                                                    <th>{{ __('messages.Vehicle Category') }}</th>
                                                    {{-- <th>status</th> --}}
                                                    <th>{{ __('messages.Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            @foreach ($vehicle as $item)
                                                <!-- Edit Vehicle Modal -->
                                                <div class="modal fade" id="editVehicleModal" tabindex="-1"
                                                    aria-labelledby="editVehicleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form id="editVehicleForm" method="POST"
                                                                action="{{ route('vehicle.update', $item) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editVehicleModalLabel">Edit Vehicle</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <input type="hidden" id="vehicle_id"
                                                                        name="vehicle_id">

                                                                    <div class="row">
                                                                        <!-- First Column -->
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="editVin"
                                                                                    class="form-label">@lang('messages.Chancy Number')</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="editVin" name="vin"
                                                                                    data-field="chancy_number"
                                                                                    required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editMake"
                                                                                    class="form-label">Make</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="editMake" name="make"
                                                                                    data-field="make" required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editModel"
                                                                                    class="form-label">@lang('messages.Model')</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="editModel" name="model"
                                                                                    data-field="model" required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editYear"
                                                                                    class="form-label">@lang('messages.Year')</label>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="editYear" name="year"
                                                                                    data-field="year" required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editPlateNumber"
                                                                                    class="form-label">@lang('messages.Plate Number')</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="editPlateNumber"
                                                                                    name="plate_number"
                                                                                    data-field="plate_number"
                                                                                    pattern="^[A-Z]{2}-\d{1}-\d{5}$"
                                                                                    required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editMileage"
                                                                                    class="form-label">@lang('messages.Mileage')</label>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="editMileage" name="mileage"
                                                                                    data-field="mileage" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="editCapacity"
                                                                                    class="form-label">@lang('messages.Capacity')</label>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="editCapacity" name="capacity"
                                                                                    data-field="capacity" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="editFuelAmount"
                                                                                    class="form-label">@lang('messages.Fuel Amount')</label>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="editFuelAmount"
                                                                                    name="fuel_amount"
                                                                                    data-field="fuel_amount" required>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Second Column -->
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label for="fuel_type"
                                                                                    class="form-label">@lang('messages.Fuel Type')</label>
                                                                                <select id="fuel_type"
                                                                                    name="fuel_type"
                                                                                    class="form-select" required>
                                                                                    <option value="Benzene" {{ $item->fuel_type == 'Benzene' ? 'selected' : '' }}>Benzene</option>
                                                                                    <option value="Diesel"{{ $item->fuel_type == 'Diesel' ? 'selected' : '' }}> Diesel</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editLastService"
                                                                                    class="form-label">@lang('messages.Last Service')</label>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="editLastService"
                                                                                    name="last_service"
                                                                                    data-field="last_service" required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editNextService"
                                                                                    class="form-label">@lang('messages.Next Service')</label>
                                                                                <input type="number"
                                                                                    class="form-control"
                                                                                    id="editNextService"
                                                                                    name="next_service"
                                                                                    data-field="next_service" required>
                                                                            </div>

                                                                            {{-- <div class="mb-3">
                                                                                <label for="editDriver"
                                                                                    class="form-label">@lang('messages.Driver')</label>
                                                                                <select id="editDriver"
                                                                                    name="driver_id"
                                                                                    class="form-select"
                                                                                    id="Previousdriver">
                                                                                    <option value="">
                                                                                        @lang('messages.Select Driver')</option>
                                                                                    @foreach ($drivers as $driver)
                                                                                    <option value="{{ $driver->driver_id }}" 
                                                                                        {{ $driver->driver_id == $driver->driver_id ? 'selected' : '' }}>
                                                                                        {{ $driver->user->first_name }} {{ $driver->user->middle_name }}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div> --}}

                                                                            <div class="mb-3">
                                                                                <div class="mb-6">
                                                                                    <label for="editLibre"
                                                                                        class="form-label">@lang('messages.Libre')</label>
                                                                                    <input type="file"
                                                                                        class="form-control"
                                                                                        id="editLibre" name="libre"
                                                                                        data-file="libre">
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <div class="mb-3">
                                                                                    <label for="editInsurance"
                                                                                        class="form-label">@lang('messages.Insurance')</label>
                                                                                    <input type="file"
                                                                                        class="form-control"
                                                                                        id="editInsurance"
                                                                                        name="insurance"
                                                                                        data-field="insurance">
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editVehicleCategory"
                                                                                    class="form-label">@lang('messages.Vehicle Category')</label>
                                                                                <select id="editVehicleCategory"
                                                                                    name="vehicle_category"
                                                                                    class="form-select" required>
                                                                                    <option value="Service"
                                                                                        {{ $item->vehicle_category == 'Service' ? 'selected' : '' }}>
                                                                                        Service</option>
                                                                                    <option value="Load"
                                                                                        {{ $item->vehicle_category == 'Load' ? 'selected' : '' }}>
                                                                                        Load</option>
                                                                                    <option value="Both"
                                                                                        {{ $item->vehicle_category == 'Both' ? 'selected' : '' }}>
                                                                                        Both</option>
                                                                                    <option value="Neither"
                                                                                        {{ $item->vehicle_category == 'Neither' ? 'selected' : '' }}>
                                                                                        Neither</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editPosition"
                                                                                    class="form-label">Position</label>
                                                                                <select id="editPosition"
                                                                                    name="position"
                                                                                    class="form-select" required>
                                                                                    <option value="Position"
                                                                                        {{ $item->position == 'Position' ? 'selected' : '' }}>
                                                                                        Position</option>
                                                                                    <option value="Other"
                                                                                        {{ $item->position == 'Other' ? 'selected' : '' }}>
                                                                                        Other</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="editVehicleType"
                                                                                    class="form-label">@lang('messages.Vehicle Type')</label>
                                                                                <select id="editVehicleType"
                                                                                    name="vehicle_type"
                                                                                    class="form-select" required
                                                                                    onchange="toggleEditFields()">
                                                                                    <option value="Organizational"
                                                                                        {{ $item->vehicle_type == 'Organizational' ? 'selected' : '' }}>
                                                                                        Organizational</option>
                                                                                    <option value="Rental"
                                                                                        {{ $item->vehicle_type == 'Rental' ? 'selected' : '' }}>
                                                                                        Rental</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach


                                            <div class="modal fade" id="viewModal" role="dialog" tabindex="-1"
                                                aria-labelledby="viewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Vehicle Details</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- First Column -->
                                                                <div class="col-md-6">
                                                                    <dl class="row mb-0">
                                                                        <dt class="col-sm-4">@lang('messages.Chancy Number'):</dt>
                                                                        <dd class="col-sm-8"
                                                                            data-field="chancy_number"></dd>

                                                                        <dt class="col-sm-4">Make:</dt>
                                                                        <dd class="col-sm-8" data-field="make"></dd>

                                                                        <dt class="col-sm-4">@lang('messages.Model'):</dt>
                                                                        <dd class="col-sm-8" data-field="model"></dd>

                                                                        <dt class="col-sm-4">@lang('messages.Year'):</dt>
                                                                        <dd class="col-sm-8" data-field="year"></dd>

                                                                        <dt class="col-sm-4">@lang('messages.Plate Number'):</dt>
                                                                        <dd class="col-sm-8"
                                                                            data-field="plate_number"></dd>

                                                                        <dt class="col-sm-4">@lang('messages.Mileage'):</dt>
                                                                        <dd class="col-sm-8" data-field="mileage">
                                                                        </dd>

                                                                        <dt class="col-sm-4">@lang('messages.Capacity'):</dt>
                                                                        <dd class="col-sm-8" data-field="capacity">
                                                                        </dd>

                                                                        <dt class="col-sm-4">@lang('messages.Fuel Amount')</dt>
                                                                        <dd class="col-sm-8" data-field="fuel_amount">
                                                                        </dd>
                                                                    </dl>
                                                                </div>

                                                                <!-- Second Column -->
                                                                <div class="col-md-6">
                                                                    <dl class="row mb-0">

                                                                        <dt class="col-sm-4">@lang('messages.Fuel Type')</dt>
                                                                        <dd class="col-sm-8" data-field="fuel_type">
                                                                        </dd>

                                                                        <dt class="col-sm-4">@lang('messages.Last Service'):</dt>
                                                                        <dd class="col-sm-8"
                                                                            data-field="last_service"></dd>

                                                                        <dt class="col-sm-4">@lang('messages.Next Service'):</dt>
                                                                        <dd class="col-sm-8"
                                                                            data-field="next_service"></dd>

                                                                        {{-- <dt class="col-sm-4">@lang('messages.Driver'):</dt>
                                                                        <dd class="col-sm-8" data-field="driver"></dd> --}}

                                                                        <dt class="col-sm-4">@lang('messages.Vehicle Category'):</dt>
                                                                        <dd class="col-sm-8"
                                                                            data-field="vehicle_category"></dd>

                                                                        <dt class="col-sm-4">Position:</dt>
                                                                        <dd class="col-sm-8" data-field="position">
                                                                        </dd>

                                                                        <dt class="col-sm-4">@lang('messages.Vehicle Type'):</dt>
                                                                        <dd class="col-sm-8"
                                                                            data-field="vehicle_type"></dd>

                                                                        <dt class="col-sm-4">@lang('messages.Rental Type')</dt>
                                                                        <dd class="col-sm-8" data-field="rental_type">
                                                                        </dd>
                                                                    </dl>
                                                                </div>
                                                            </div>
                                                           
                                                            <!-- Files section (still within the two-column structure) -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @if ($item->libre) 
                                                                        <dl class="row mb-0">
                                                                            <dt class="col-sm-4">@lang('messages.Libre'):
                                                                            </dt>
                                                                            <dd class="col-sm-8" data-field="libre">
                                                                            </dd>
                                                                        </dl>
                                                                    @endif
                                                                </div>

                                                                <div class="col-md-6">
                                                                    @if ($item->insurance)
                                                                        <dl class="row mb-0">
                                                                            <dt class="col-sm-4">@lang('messages.Insurance'):
                                                                            </dt>
                                                                            <dd class="col-sm-8"
                                                                                data-field="insurance"></dd>
                                                                        </dl>
                                                                    @endif
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

                                        <!-- Accept Alert Modal -->
                                        <div id="warning_alert" class="modal fade" id="confirmationModal"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    {{-- <form method="POST" action="{{ route('vehicle.destroy',$item) }}"> --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="request_id" id="request_id">
                                                    <div class="modal-body p-4">
                                                        <div class="text-center">
                                                            <i class="ri-alert-line h1 text-warning"></i>
                                                            <h4 class="mt-2">Warning</h4>
                                                            <h5 class="mt-3">
                                                                Are you sure you want to delete this vehicle?</br> This
                                                                action
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>


    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(function() {
            var table = $('.vehicle_datatable').DataTable({

                pageLength: 5,
                ajax: "{{ route('vehicle.list') }}",
                columns: [{
                        data: 'plate_number',
                        name: 'plate_number'
                    },
                    {
                        data: 'vehicle_type',
                        name: 'vehicle_type'
                    },
                    {
                        data: 'vehicle_category',
                        name: 'vehicle_category'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
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
        $(document).ready(function() {})
        $(document).on('click', '.view-btn', function() {
            var modal = $('#viewModal');

            modal.find('.modal-title').text('Vehicle Details');
            modal.find('[data-field="chancy_number"]').text($(this).data('chancy_number'));
            modal.find('[data-field="make"]').text($(this).data('make'));
            modal.find('[data-field="model"]').text($(this).data('model'));
            modal.find('[data-field="year"]').text($(this).data('year'));
            modal.find('[data-field="plate_number"]').text($(this).data('plate_number'));
            modal.find('[data-field="mileage"]').text($(this).data('mileage'));
            modal.find('[data-field="capacity"]').text($(this).data('capacity'));
            modal.find('[data-field="fuel_amount"]').text($(this).data('fuel_amount'));
            modal.find('[data-field="fuel_type"]').text($(this).data('fuel_type'));
            modal.find('[data-field="last_service"]').text($(this).data('last_service'));
            modal.find('[data-field="next_service"]').text($(this).data('next_service'));
            // modal.find('[data-field="driver"]').text($(this).data('driver'));
            modal.find('[data-field="vehicle_category"]').text($(this).data('vehicle_category'));
            modal.find('[data-field="position"]').text($(this).data('position'));
            modal.find('[data-field="vehicle_type"]').text($(this).data('vehicle_type'));
            modal.find('[data-field="rental_type"]').text($(this).data('rental_type'));
            modal.find('[data-field="libre"]').text($(this).data('libre'));
            modal.find('[data-field="insurance"]').text($(this).data('insurance'));

            modal.modal('show');
        });
    </script>

    <script>
        $(document).on('click', '.edit-btn', function() {
            var modal = $('#editVehicleModal');
            console.log($(this).data('libre'));
            modal.find('.modal-title').text('Edit Vehicle');
            modal.find('[data-field="chancy_number"]').val($(this).data('chancy_number'));
            modal.find('[data-field="make"]').val($(this).data('make'));
            modal.find('[data-field="model"]').val($(this).data('model'));
            modal.find('[data-field="year"]').val($(this).data('year'));
            modal.find('[data-field="plate_number"]').val($(this).data('plate_number'));
            modal.find('[data-field="mileage"]').val($(this).data('mileage'));
            modal.find('[data-field="capacity"]').val($(this).data('capacity'));
            modal.find('[data-field="fuel_amount"]').val($(this).data('fuel_amount'));
            // modal.find('[data-field="fuel_type"]').val($(this).data('fuel_type'));
            modal.find('[data-field="last_service"]').val($(this).data('last_service'));
            modal.find('[data-field="next_service"]').val($(this).data('next_service'));
            // modal.find('#Previousdriver').val($(this).data('driver'));
            modal.find('[data-field="libre"]').text($(this).data('libre'));
            modal.find('[data-field="insurance"]').text($(this).data('insurance'));

            modal.modal('show');
        });
    </script>

    <script>
        src = "{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" >
    </script>

    <script>
        document.getElementById('nextBtn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            document.getElementById('second').scrollIntoView({
                behavior: 'smooth'
            }); // Scroll to the form
        });
    </script>

    <script>
        function toggleFields() {
            const vehicleType = document.getElementById('vehicleType').value; // Get the selected value
            const rentalDiv = document.getElementById('rentalDiv'); // Get the rental type div

            // Show or hide the rental type div based on the selected value
            if (vehicleType === 'Rental') {
                rentalDiv.style.display = 'block'; // Show when "Rental" is selected
            } else {
                rentalDiv.style.display = 'none'; // Hide for other options
            }
        }
    </script>

    <script>
        function populateModal(data) {
            // Set the form action URL with the correct vehicle ID
            const formAction = document.getElementById('editVehicleForm').action.replace(':vehicle_id', data.id);
            document.getElementById('editVehicleForm').action = formAction;

            // Populate the fields with the data
            document.getElementById('vehicle_id').value = data.id;
            document.getElementById('editVin').value = data.vin;
            document.getElementById('editMake').value = data.make;
            document.getElementById('editModel').value = data.model;
            document.getElementById('editYear').value = data.year;
            document.getElementById('editPlateNumber').value = data.plate_number;
            document.getElementById('editMileage').value = data.mileage;
            document.getElementById('editCapacity').value = data.capacity;
            document.getElementById('editFuelAmount').value = data.fuel_amount;
            document.getElementById('editFuelType').value = data.fuel_type;
            document.getElementById('editLastService').value = data.last_service;
            document.getElementById('editNextService').value = data.next_service;
            document.getElementById('editNotes').value = data.notes;
            document.getElementById('editDriver').value = data.driver;
            document.getElementById('editVehicleCategory').value = data.vehicle_category;
            document.getElementById('editVehicleType').value = data.vehicle_type;

        }
    </script>



    <!-- Bootstrap Wizard Form js -->
    <script src="assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

    <!-- Wizard Form Demo js -->
    <script src="assets/js/pages/form-wizard.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
@endsection

<script src="assets/js/vendor.min.js"></script>
