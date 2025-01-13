@extends('layouts.navigation')
@section('content')

<div class="wrapper">

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    

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
            <!-- Start Content-->
            <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid">
        <div class="row">
<div class="col-5">
    <div class="card">
        <div class="card-header">
            <h4 class="header-title mb-0">Vehicle Registration</h4>
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
                                <span class="d-none d-sm-inline">Basic</span>
                            </a>
                        </li>
                        <li class="nav-item" data-target-form="#profileForm">
                            <a href="#second" data-bs-toggle="tab" data-toggle="tab"  class="nav-link rounded-0 py-2">
                                <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                <span class="d-none d-sm-inline">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item" data-target-form="#otherForm">
                            <a href="#third" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                <span class="d-none d-sm-inline">Type</span>
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
                            <form method="POST" action="{{ route('vehicleRegistration.store') }}" accept-charset="UTF-8" name="ebook-form" id="ebook-form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="Chancy Number">Chancy Number</label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" id="Chancy Number" placeholder="Enter the Chancy number" name="vin" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="make"> Make</label>
                                            <div class="col-md-9">
                                                <input type="text" id="Make" name="make" placeholder="Enter the make" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="model">Model</label>
                                            <div class="col-md-9">
                                                <input type="text" id="Model" name="model" placeholder="Enter the model" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="year">Year</label>
                                            <div class="col-md-9">
                                                <input type="number" id="Year" name="year" placeholder="Enter the year" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="plate_number">Plate Number</label>
                                            <div class="col-md-9">
                                                <input type="text" id="Plate Number" name="plate_number"  pattern="^[A-Z]{2}-\d{1}-\d{5}$" placeholder="AA-1-12345" class="form-control" required>
                                            </div>
                                        </div>

                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            <ul class="list-inline wizard mb-0">
                                <li class="next list-inline-item float-end">
                                    <a href="#" class="btn btn-info" id="nextBtn">Next <i class="ri-arrow-right-line ms-1"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-pane fade" id="second">
                            <form id="profileForm" method="post" action="#" class="form-horizontal">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="mileage">Mileage</label>
                                            <div class="col-md-9">
                                                <input type="number" id="Mileage" name="mileage" placeholder="Enter the mileage" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="fuel amount">Fuel Amount</label>
                                            <div class="col-md-9">
                                                <input type="number" id="fuel amount" name="fuel_amount" placeholder="Enter the fuel amount" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="fuel_type">Fuel Type</label>
                                            <div class="col-md-9">
                                                <select id="fuel_type" name="fuel_type" class="form-select" required>
                                                    <option value="">Select Fuel Type</option>
                                                    <option value="Benzene">Benzene</option>
                                                    <option value="Diesel">Diesel</option>
                                                    <option value="Electric">Electric</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="capacity">Capacity</label>
                                            <div class="col-md-9">
                                                <input type="number" id="capacity" name="capacity" placeholder="Enter the max Capacity" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="Last Service">Last Service</label>
                                            <div class="col-md-9">
                                                <input type="number" id="Last Service" name="Last_Service" placeholder="Enter the last service KM" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="Next Service">Next Service</label>
                                            <div class="col-md-9">
                                                <input type="number" id="Next Service" name="Next_Service" placeholder="Enter the next service KM" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="Notes">Notes</label>
                                            <div class="col-md-9">
                                                <input type="text" id="Notes" name="Notes" placeholder="Enter your notes here" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            <ul class="pager wizard mb-0 list-inline">
                                <li class="previous list-inline-item">
                                    <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back </button>
                                </li>
                                <li class="next list-inline-item float-end">
                                    <button type="button" class="btn btn-info">Next <i class="ri-arrow-right-line ms-1"></i></button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-pane fade" id="third">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="driver">Driver</label>
                                            <div class="col-md-9">
                                                <select id="driver" name="driver" class="form-select">
                                                    <option value="">Select Driver</option>
                                                    @foreach($drivers as $driver)
                                                        <option value="{{ $driver->driver_id }}">{{ $driver->user->first_name." ". $driver->user->middle_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                       
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="vehicle_category">Service</label>
                                            <div class="col-md-9">
                                                <select id="vehicleCategory" name="vehicle_category" class="form-select" required>
                                                    <option value="">Select Vehicle service</option>
                                                    <option value="human">Human</option>
                                                    <option value="load">Load</option>
                                                    <option value="both">Both</option>
                                                    <option value="position">Position</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="Libre">Libre</label>
                                            <div class="col-md-9">
                                                <input type="file" id="Libre" name="libre" class="form-control" required>
                                            </div>
                                        </div>
                                    
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="Insurance">Insurance</label>
                                            <div class="col-md-9">
                                                <input type="file" id="Insurance" name="insurance" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="vehicle_type">Owner</label>
                                            <div class="col-md-9">
                                                <select id="vehicleType" name="vehicle_type" class="form-select" required onchange="toggleFields()">
                                                    <option value="">Select owner</option>
                                                    <option value="Organizational">Organizational</option>
                                                    <option value="other">Rental</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3" id="rentalDiv" style="display: none;">
                                            <div class="col-md-9">
                                                <label class="col-md-3 col-form-label" for="rental_type">Rental Type</label>
                                                <select id="rentalType" name="rental_type" class="form-select">
                                                    <option value="">Select Type</option>
                                                    <option value="whole_day">Whole Day</option>
                                                    <option value="position">Position</option>
                                                    <option value="40/60">45/60</option>
                                                    <option value="morning_afternoon_minibus">Morning Afternoon Minibus</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            <ul class="pager wizard mb-0 list-inline mt-1">
                                <li class="previous list-inline-item">
                                    <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back </button>
                                </li>
                                <!-- Your form fields go here -->
                                    
                                    <li class="next list-inline-item float-end">
                                        <button type="submit" class="btn btn-info">Submit</button>
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
                                    <h4 class="header-title mb-0">Vehicle List</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="lms_table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Plate Number</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Vehicle Category</th>
                                                    {{-- <th>status</th> --}}
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vehicle as $item)
                                                
                                                <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $item->plate_number }}</td>
                                                <td>{{ $item->vehicle_type }}</td>
                                                <td>{{ $item->vehicle_category }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('vehicle.destroy',$item) }}"accept-charset="UTF-8">
                                                        @method('DELETE')
                                                        <input  name="request_id" value="{{ $item->vehicle_id }}" type="hidden">
                                                        {{ csrf_field() }}
                                                        <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#viewModal{{ $item->vehicle_id }}">
                                                            <i class="ri-eye-line"></i>
                                                        </button>
                                                        <a type="button" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#editVehicleModal" 
                                                            onclick="populateModal({
                                                                    id: '{{ $item->vehicle_id }}',
                                                                    vin: '{{ $item->vin }}',
                                                                    make: '{{ $item->make }}',
                                                                    model: '{{ $item->model }}',
                                                                    year: '{{ $item->year }}',
                                                                    plate_number: '{{ $item->plate_number }}',
                                                                    mileage: '{{ $item->mileage }}',
                                                                    capacity: '{{ $item->capacity }}',
                                                                    fuel_amount: '{{ $item->fuel_amount }}',
                                                                    fuel_type: '{{ $item->fuel_type }}',
                                                                    last_service: '{{ $item->last_service }}',
                                                                    next_service: '{{ $item->next_service }}',
                                                                    notes: '{{ $item->notes }}',
                                                                    driver: '{{ $item->driver_id }}',
                                                                    vehicle_category: '{{ $item->vehicle_category }}',
                                                                    vehicle_type: '{{ $item->vehicle_type }}',
                                                                    libre: '{{ $item->libre }}',
                                                                    insurance: '{{ $item->insurance }}'
                                                            })">
                                                                <i class="ri-edit-line"></i>
                                                            </a>

                                                        <button type="button" class="btn btn-danger rounded-pill" title="Delete Vehicle"
                                                        data-bs-toggle="modal" data-bs-target="#warning_alert">
                                                        <i class="ri-close-circle-line"></i> </button>
                                                  </form>
                                                 </td> 
                                                </tr>
                                                <!-- Edit Vehicle Modal -->
<div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editVehicleForm" method="POST" action="{{ route('vehicle.update', ':vehicle_id') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editVehicleModalLabel">Edit Vehicle Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="vehicle_id" name="vehicle_id">
                
                    <div class="row">
                        <!-- First Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editVin" class="form-label">Chancy Number</label>
                                <input type="text" class="form-control" id="editVin" name="vin" value="{{ $item->vin }}" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editMake" class="form-label">Make</label>
                                <input type="text" class="form-control" id="editMake" name="make" value="{{ $item->make }}" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editModel" class="form-label">Model</label>
                                <input type="text" class="form-control" id="editModel" name="model" value="{{ $item->model }}" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editYear" class="form-label">Year</label>
                                <input type="number" class="form-control" id="editYear" name="year" value="{{ $item->year }}" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editPlateNumber" class="form-label">Plate Number</label>
                                <input type="text" class="form-control" id="editPlateNumber" name="plate_number" value="{{ $item->plate_number }}" pattern="^[A-Z]{2}-\d{1}-\d{5}$" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editMileage" class="form-label">Mileage</label>
                                <input type="number" class="form-control" id="editMileage" name="mileage" value="{{ $item->mileage }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCapacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="editCapacity" name="capacity" value="{{ $item->capacity }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editFuelAmount" class="form-label">Fuel Amount</label>
                                <input type="number" class="form-control" id="editFuelAmount" name="fuel_amount" value="{{ $item->fuel_amount }}" required>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="editRentalType_{{ $item->vehicle_id }}" class="form-label">Rental Type</label>
                                <select id="editRentalType_{{ $item->vehicle_id }}" name="rental_type" class="form-select">
                                    <option value="40/60" {{ $item->rental_type == '40/60' ? 'selected' : '' }}>40/60</option>
                                    <option value="Position" {{ $item->rental_type == 'Position' ? 'selected' : '' }}>Position</option>
                                    <option value="morning_afternoon_minibus" {{ $item->rental_type == 'morning_afternoon_minibus' ? 'selected' : '' }}>Morning Afternoon</option>
                                    <option value="whole_day" {{ $item->rental_type == 'whole_day' ? 'selected' : '' }}>Whole Day</option>
                                </select>
                            </div> --}}
                        </div>
                
                        <!-- Second Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editFuelType" class="form-label">Fuel Type</label>
                                <input type="text" class="form-control" id="editFuelType" name="fuel_type" value="{{ $item->fuel_type }}" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editLastService" class="form-label">Last Service</label>
                                <input type="number" class="form-control" id="editLastService" name="last_service" value="{{ $item->last_service }}" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editNextService" class="form-label">Next Service</label>
                                <input type="number" class="form-control" id="editNextService" name="next_service" value="{{ $item->next_service }}" required>
                            </div>
                
                            <div class="mb-3">
                                <label for="editDriver" class="form-label">Driver</label>
                                <select id="editDriver" name="driver_id" class="form-select">
                                    <option value="">Select Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->driver_id}}">{{$driver->user->first_name}} + {{$driver->user->second_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="mb-6">
                                    <label for="editLibre" class="form-label">Libre</label>
                                    <input type="file" class="form-control" id="editLibre" name="libre">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="editInsurance" class="form-label">Insurance</label>
                                    <input type="file" class="form-control" id="editInsurance" name="insurance">
                                </div>
                            </div>
                
                            <div class="mb-3">
                                <label for="editVehicleCategory" class="form-label">Vehicle Category</label>
                                <select id="editVehicleCategory" name="vehicle_category" class="form-select" required>
                                    <option value="Service" {{ $item->vehicle_category == 'Service' ? 'selected' : '' }}>Service</option>
                                    <option value="Load" {{ $item->vehicle_category == 'Load' ? 'selected' : '' }}>Load</option>
                                    <option value="Both" {{ $item->vehicle_category == 'Both' ? 'selected' : '' }}>Both</option>
                                    <option value="Neither" {{ $item->vehicle_category == 'Neither' ? 'selected' : '' }}>Neither</option>
                                </select>
                            </div>
                
                            <div class="mb-3">
                                <label for="editVehicleType" class="form-label">Vehicle Type</label>
                                <select id="editVehicleType" name="vehicle_type" class="form-select" required onchange="toggleEditFields()">
                                    <option value="Organizational" {{ $item->vehicle_type == 'Organizational' ? 'selected' : '' }}>Organizational</option>
                                    <option value="Other" {{ $item->vehicle_type == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal{{ $item->vehicle_id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $item->vehicle_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel{{ $item->vehicle_id }}">Vehicle Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- First Column -->
                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Chancy Number:</dt>
                            <dd class="col-sm-8">{{ $item->vin }}.</dd>
            
                            <dt class="col-sm-4">Make:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->make }}.</p>
                            </dd>
            
                            <dt class="col-sm-4">Model:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->model }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Year:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->year }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Plate Number:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->plate_number }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Mileage:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->mileage }}</p>
                            </dd>

                            <dt class="col-sm-4">Capacity:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->capacity }}</p>
                            </dd>
                            <dt class="col-sm-4">Fuel Amount:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->fuel_amount }}</p>
                            </dd>
                        </dl>
                    </div>
            
                    <!-- Second Column -->
                    <div class="col-md-6">
                        <dl class="row mb-0">
            
                            <dt class="col-sm-4">Fuel Type:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->fuel_type }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Last Service:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->last_service }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Next Service:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->next_service }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Driver:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->driver_id ? $item->driver->user->first_name : "No driver" }}  {{ $item->driver_id ? $driver->user->middle_name : "" }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Vehicle Category:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->vehicle_category }}</p>
                            </dd>
            
                            <dt class="col-sm-4">Vehicle Type:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->vehicle_type }}</p>
                            </dd>
                            <dt class="col-sm-4">Rental Type:</dt>
                            <dd class="col-sm-8">
                                <p>{{ $item->rental_type }}</p>
                            </dd>
                        </dl>
                    </div>
                </div>
            
                <!-- Files section (still within the two-column structure) -->
                <div class="row">
                    <div class="col-md-6">
                        @if($item->libre)
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Libre:</dt>
                            <dd class="col-sm-8">
                                <p>
                                    <a href="{{ Storage::url('vehicles/' . $item->libre) }}" target="_blank">View File</a>
                                </p>
                            </dd>
                        </dl>
                        @endif
                    </div>                    
            
                    <div class="col-md-6">
                        @if($item->insurance)
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Insurance:</dt>
                            <dd class="col-sm-8">
                                <p><a href="{{ Storage::url('vehicles/' . $item->insurance) }}" target="_blank">View File</a></p>
                            </dd>
                        </dl>
                        @endif
                    </div>
                </div>
            
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Accept Alert Modal -->
                                    <div id="warning_alert" class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
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
                                                            Are you sure you want to delete this vehicle?</br> This action
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

                    </div> <!-- tab-content -->
                </div> <!-- end #rootwizard-->
</div>
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div> <!-- end col -->
</div> 
<

        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $vehicle->links() }}
</div>

<script>
    document.getElementById('nextBtn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById('second').scrollIntoView({ behavior: 'smooth' }); // Scroll to the form
    });
</script>

<script>
    function toggleFields() {
        const vehicleType = document.getElementById('vehicleType').value; // Get the selected value
        const rentalDiv = document.getElementById('rentalDiv'); // Get the rental type div

        // Show or hide the rental type div based on the selected value
        if (vehicleType === 'other') {
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

<script src="assets/js/vendor.min.js"></script>
        
<!-- Bootstrap Wizard Form js -->
<script src="assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

<!-- Wizard Form Demo js -->
<script src="assets/js/pages/form-wizard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

@endsection