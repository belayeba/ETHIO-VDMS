@extends('layouts.navigation')
@section('content')

<style>
    .badge {
        font-size: 0.9em;
        padding: 0.3em 0.5em;
        margin-right: 0.2em;
    }
    .remove-tag {
        cursor: pointer;
        margin-left: 0.3em;
    }
    </style>

<div class="content-page">
    <div class="content">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Request Vehicle</h4>
                    </div>
                    <div class="card-body"> 
                        <form method="POST" action="{{route('temp_request_post')}}">
                            @csrf

                            <div id="progressbarwizard">
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                    <li class="nav-item">
                                        <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Request</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class="ri-timer-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Duration</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class=" ri-map-pin-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Location</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#finish-3" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class=" ri-suitcase-3-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Cargo</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0">

                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                                </div>
                            
                                <div class="tab-pane" id="account-2">
                                    <div class="row">
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Reason</label>
                                                <input type="text" name="purpose" class="form-control" placeholder="Enter purpose of Request"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Vehicle type</label>
                                                <input type="text" class="form-control" name="vehicle_type" placeholder="Select vehicle type"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline wizard mb-0">
                                        <li class="next list-inline-item float-end">
                                            <a href="javascript:void(0);" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></a>
                                        </li>
                                    </ul>
                                </div> 

                                <div class="tab-pane" id="profile-tab-2">
                                    <div class="row">
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="start_date" placeholder="Enter Date of departure"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>
                            
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Start Time</label>
                                                <input type="time" class="form-control" name="start_time" placeholder="Enter Time of departure"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Return Date</label>
                                                <input type="date" class="form-control" name="return_date" placeholder="Enter Date of arrival"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Return Time</label>
                                                <input type="time" class="form-control" name="return_time" placeholder="Enter Time of arrival"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>
                                    </div> 
                                        <ul class="pager wizard mb-0 list-inline">
                                            <li class="previous list-inline-item">
                                                <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                            </li>
                                            <li class="next list-inline-item float-end">
                                                <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                            </li>
                                        </ul>
                                </div> 
                                
                                <div class="tab-pane" id="finish-2">
                                    <div class="row">
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Location From</label>
                                                <input type="text" class="form-control" name="start_location" placeholder="Enter starting location"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Location to</label>
                                                <input type="text" class="form-control" name="end_location" placeholder="Enter arrival location"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                                </div>
                                            </div>
                                        </div> <!-- end card-body-->
                                            <ul class="pager wizard mb-0 list-inline mt-1">
                                                <li class="previous list-inline-item">
                                                    <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Profile</button>
                                                </li>
                                                <li class="next list-inline-item float-end">
                                                    <a href="#finish-3" type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></a>
                                                </li>
                                            </ul>
                                </div>   
                                <div class="tab-pane" id="finish-3">
                                    <div class="row">

                                        <p class="mb-1 fw-bold text-muted">Select People</p>
                                        <select id="multiSelect" name="people_id[]" class="select2 form-control select2-multiple" data-toggle="select2"
                                            multiple="multiple" data-placeholder="Select People ...">
                                            <optgroup label="Users/Employees">
                                                @foreach($users as $user);
                                                <option value="{{$user->id}}"><p style="color:black">{{$user->first_name}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div id="selectedValues" class="mt-2"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker1">
                                                <label for="itemName" class="form-label">Item Name:</label>
                                                <input type="text" class="form-control" placeholder="Add Item"
                                                id="itemName">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker2">
                                                <label for="itemWeight" class="form-label">Weight (kg):</label>
                                                <input type="text" class="form-control" placeholder="Add weight"
                                                id="itemWeight" step="0.01" min="0" >
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                                            <button type="button" class="btn btn-primary rounded-pill" id="addItem">Add</button>
                                        </div>
                                        </div>
                
                                        <div id="itemList"></div>
                                            <ul class="pager wizard mb-0 list-inline mt-1">
                                                <li class="previous list-inline-item">
                                                    <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Profile</button>
                                                </li>
                                                <li class="next list-inline-item float-end">
                                                    <button type="submit" class="btn btn-info">Submit</button>
                                                </li>
                                            </ul>  
                                        </div>
                                </div>  
                            </div>

                        </form> 

                    </div> <!-- end card-->
             </div> <!-- end col-->
            </div>

            <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plate Number</th>
                                <th>Vehicle Type</th>
                                <th>Model</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        {{-- @foreach($Requested as $request)
                            <tbody>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$request->start_date}}</td>
                                    <td>From:{{$request->start_location}},</br>To:{{$request->end_locations}}</td>
                                    <td><button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#cargo-modal-{{ $loop->index }}"><i class=" ri-suitcase-3-line"></i></button></td>
                                    <td>{{$request->status}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="show"><i class=" ri-eye-line"></i></button>
                                        <a href="{{route('editRequestPage', ['id' => $request->request_id])}}" class="btn btn-secondary rounded-pill" title="edit"><i class=" ri-edit-line"></i></a>
                                    </td>
                                </tr>
                            </tbody> --}}
                            <!-- show passengers and materials modal -->
                                {{-- <div class="modal fade" id="cargo-modal-{{ $loop->index }}" tabindex="-1" aria-labelledby="cargo-modal-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cargo-modal-label">Passenger and Cargo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div> --}}
                                            {{-- <div class="modal-body">
                                                <!-- Populate modal with associated people -->
                                                @foreach($request->peoples as $person)
                                                    <p>Passenger name: {{ $person->user->first_name }}&nbsp;{{ $person->user->last_name }}</p>
                                                @endforeach
                                                <!-- Populate modal with associated materials -->
                                                @foreach($request->materials as $material)
                                                    <p>Material name: {{ $material->material_name }},&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br> Material Weight: {{ $material->weight }}</p>
                                                @endforeach
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
    </div>
</div>
    </div>
</div>

@endsection
<script src="assets/vendor/select2/js/select2.min.js"></script>
 <!-- Typehead Demo js -->
<script src="assets/js/pages/typehead.init.js"></script>
   <!-- Typehead Plugin js -->
<script src="assets/vendor/handlebars/handlebars.min.js"></script>
<script src="assets/vendor/typeahead.js/typeahead.bundle.min.js"></script>

<script src="assets/js/pages/datatable.init.js"></script>
<script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>