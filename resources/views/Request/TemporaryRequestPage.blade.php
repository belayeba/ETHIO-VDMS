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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Request Vehicle Service</h4>
                            </div>
                            <div class="card-body">
                                <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
                                <form method="POST" action="{{ route('temp_request_post') }}">
                                    @csrf

                                    <div id="progressbarwizard">
                                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                            <li class="nav-item">
                                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Request</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-timer-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Duration</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class=" ri-map-pin-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Location</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#finish-3" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class=" ri-information-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Info</span>
                                                </a>
                                            </li>
                                            <!-- <li class="nav-item">
                                            <a href="#finish-4" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                <i class=" ri-suitcase-3-fill fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">Extras</span>
                                            </a>
                                        </li> -->
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
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Reason</label>
                                                            <input type="text" name="purpose" class="form-control"
                                                                placeholder="Enter purpose of Request"
                                                                
                                                                >
                                                        </div>
                                                    </div>

                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Vehicle type</label>
                                                            <input type="text" class="form-control" name="vehicle_type"
                                                                placeholder="Select vehicle type"
                                                                
                                                                >
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="list-inline wizard mb-0">
                                                    <li class="next list-inline-item float-end">
                                                        <a href="javascript:void(0);" class="btn btn-info">Add More Info <i
                                                                class="ri-arrow-right-line ms-1"></i></a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="tab-pane" id="profile-tab-2">
                                                <div class="row">
                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Start Date</label>
                                                            <input type="text" class="form-control" name="start_date"
                                                                placeholder="Enter Date of departure" id="startdate">
                                                        </div>
                                                        <script>
                                                            $('#startdate').calendarsPicker({
                                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                                pickerClass: 'myPicker',
                                                                dateFormat: 'yyyy-mm-dd'
                                                            });
                                                        </script>
                                                    </div>

                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Start Time</label>
                                                            <input type="time" class="form-control" name="start_time"
                                                                placeholder="Enter Time of departure"
                                                                >
                                                        </div>
                                                    </div>

                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Return Date</label>
                                                            <input type="text" class="form-control" name="return_date"
                                                                placeholder="Enter Date of arrival" id="enddate">
                                                        </div>
                                                        <script>
                                                            $('#enddate').calendarsPicker({
                                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                                pickerClass: 'myPicker',
                                                                dateFormat: 'yyyy-mm-dd'
                                                            });
                                                        </script>
                                                    </div>

                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Return Time</label>
                                                            <input type="time" class="form-control" name="return_time"
                                                                placeholder="Enter Time of arrival"
                                                                
                                                                >
                                                        </div>
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">How many Days</label>
                                                            <input type="number" class="form-control"
                                                                name="how_many_days" placeholder="Enter the Duration"
                                                                
                                                                >
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="pager wizard mb-0 list-inline">
                                                    <li class="previous list-inline-item">
                                                        <button type="button" class="btn btn-light"><i
                                                                class="ri-arrow-left-line me-1"></i> Back to
                                                            Account</button>
                                                    </li>
                                                    <li class="next list-inline-item float-end">
                                                        <button type="button" class="btn btn-info">Add More Info <i
                                                                class="ri-arrow-right-line ms-1"></i></button>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="tab-pane" id="finish-2">
                                                <div class="row">
                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Location From</label>
                                                            <input type="text" class="form-control"
                                                                name="start_location"
                                                                placeholder="Enter starting location"
                                                                
                                                                >
                                                        </div>
                                                    </div>

                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Location to</label>
                                                            <input type="text" class="form-control"
                                                                name="end_location" placeholder="Enter arrival location"
                                                                
                                                                >
                                                        </div>
                                                    </div>
                                                </div> <!-- end card-body-->
                                                <ul class="pager wizard mb-0 list-inline mt-1">
                                                    <li class="previous list-inline-item">
                                                        <button type="button" class="btn btn-light"><i
                                                                class="ri-arrow-left-line me-1"></i> Back to
                                                            Profile</button>
                                                    </li>
                                                    <li class="next list-inline-item float-end">
                                                        <a href="#finish-3" type="button" class="btn btn-info">Add More
                                                            Info <i class="ri-arrow-right-line ms-1"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane" id="finish-3">
                                                <div class="row">
                                                    <h6 class="fs-15 mt-3">Do you need driver</h6>
                                                    <div class="mt-2">
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="with_driver" value="1">
                                                            <label class="form-check-label">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="with_driver" value="0">
                                                            <label class="form-check-label">No</label>
                                                        </div>
                                                    </div>
                                                    <h6 class="fs-15 mt-3">In/Out Town</h6>
                                                    <div class="mt-2">
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="in_out_town" value="1">
                                                            <label class="form-check-label">In town</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="in_out_town" value="0">
                                                            <label class="form-check-label">Out town</label>
                                                        </div>
                                                    </div>
                                                    <h6 class="fs-15 mt-3">Is there a Passenger or Package?</h6>
                                                    <div class="mt-2">
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="package" value="1">
                                                            <label class="form-check-label">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="package" value="0">
                                                            <label class="form-check-label">No</label>
                                                        </div>
                                                    </div></br>
                                                    <div id="TogglePackage" style="display:none">
                                                        <div class="row">

                                                            <p class="mb-1 fw-bold text-muted">Select People</p>
                                                            <select id="multiSelect" name="people_id[]"
                                                                class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple"
                                                                data-placeholder="Select People ...">
                                                                <optgroup label="Users/Employees">
                                                                    @foreach ($users as $user)
                                                                        ;
                                                                        <option value="{{ $user->id }}">
                                                                            <p style="color:black">{{ $user->first_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                            <div id="selectedValues" class="mt-2"></div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3 position-relative" id="datepicker1">
                                                                    <label for="itemName" class="form-label">Item
                                                                        Name:</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Add Item" id="itemName">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3 position-relative" id="datepicker2">
                                                                    <label for="itemWeight" class="form-label">Weight
                                                                        (kg):</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Add weight" id="itemWeight"
                                                                        step="0.01" min="0">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                                                                <button type="button"
                                                                    class="btn btn-primary rounded-pill"
                                                                    id="addItem">Add</button>
                                                            </div>
                                                        </div>

                                                        <div id="itemList"></div>
                                                    </div>
                                                </div>
                                                <ul class="pager wizard mb-0 list-inline mt-1">
                                                    <li class="previous list-inline-item">
                                                        <button type="button" class="btn btn-light"><i
                                                                class="ri-arrow-left-line me-1"></i> Back to
                                                            Profile</button>
                                                    </li>
                                                    <li class="next list-inline-item float-end">
                                                        <button type="submit" class="btn btn-info">Submit</button>
                                                    </li>
                                                </ul>
                                            </div>

                                            <script>
                                                //  window.onload = function() {
                                                //         location.reload();
                                                //     };
                                                const checkboxes = document.querySelectorAll(
                                                    'input[name="with_driver"], input[name="in_out_town"], input[name="package"]');
                                                const packageCheckbox = document.querySelector('input[name="package"]');
                                                const divToToggle = document.getElementById('TogglePackage');

                                                checkboxes.forEach((checkbox) => {
                                                    checkbox.addEventListener('change', function() {
                                                        checkboxes.forEach((cb) => {
                                                            if (cb !== this && cb.name === this.name) {
                                                                cb.checked = false;
                                                                divToToggle.style.display = 'none';

                                                            }
                                                        });
                                                    });
                                                });

                                                packageCheckbox.addEventListener('change', function() {
                                                    if (divToToggle) {
                                                        if (packageCheckbox.value === '1') {
                                                            divToToggle.style.display = 'block'; // Display the div if the checkbox value is 1
                                                        } else {
                                                            divToToggle.style.display = 'none';
                                                        }
                                                    }
                                                });
                                            </script>
                                        </div></br> <!-- end card-body-->
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
                                            <th>Roll.no</th>
                                            <th>Date</th>
                                            <th>location</th>
                                            <th>Cargo</th>
                                            <th>status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    @foreach ($Requested as $request)
                                        <tbody>
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $request->start_date }}</td>
                                                <td>From:{{ $request->start_location }},</br>To:{{ $request->end_locations }}
                                                </td>
                                                <td><button type="button" class="btn btn-info rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#cargo-modal-{{ $loop->index }}"><i
                                                            class=" ri-suitcase-3-line"></i></button></td>
                                                <td>{{ $request->status }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#standard-modal-{{ $loop->index }}"
                                                        title="show"><i class=" ri-eye-line"></i></button>
                                                    @if ($request->approved_by === null && $request->director_reject_reason === null)
                                                        <a href="{{ route('editRequestPage', ['id' => $request->request_id]) }}"
                                                            class="btn btn-secondary rounded-pill" title="edit"><i
                                                                class=" ri-edit-line"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!-- show passengers and materials modal -->
                                        <div class="modal fade" id="cargo-modal-{{ $loop->index }}" tabindex="-1"
                                            aria-labelledby="cargo-modal-label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="cargo-modal-label">Passenger and Cargo
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Populate modal with associated people -->
                                                        @foreach ($request->peoples as $person)
                                                            <p>Passenger name:
                                                                {{ $person->user->first_name }}&nbsp;{{ $person->user->last_name }}
                                                            </p>
                                                        @endforeach
                                                        <!-- Populate modal with associated materials -->
                                                        @foreach ($request->materials as $material)
                                                            <p>Material name:
                                                                {{ $material->material_name }},&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br>
                                                                Material Weight: {{ $material->weight }}</p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end cargo-modal -->

                                        <!-- show all the information about the request modal -->
                                        <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Request Details
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-3">Request reason</dt>
                                                            <dd class="col-sm-9">{{ $request->purpose }}.</dd>

                                                            <dt class="col-sm-3">Requested vehicle</dt>
                                                            <dd class="col-sm-9">
                                                                <p>{{ $request->vehicle_type }}.</p>
                                                            </dd>

                                                            <dt class="col-sm-3">Start date and Time</dt>
                                                            <dd class="col-sm-9">{{ $request->start_date }},
                                                                {{ $request->start_time }}.</dd>

                                                            <dt class="col-sm-3">Return date and Time</dt>
                                                            <dd class="col-sm-9">{{ $request->end_date }},
                                                                {{ $request->end_time }}.</dd>

                                                            <dt class="col-sm-3">Location From and To</dt>
                                                            <dd class="col-sm-9">{{ $request->start_location }},
                                                                {{ $request->end_locations }}.</dd>

                                                            <dt class="col-sm-3 text-truncate">passenger</dt>

                                                            <dd class="col-sm-9">
                                                                @foreach ($request->peoples as $person)
                                                                    {{ $person->user->first_name }}.</br>
                                                                @endforeach
                                                            </dd>
                                                            <dt class="col-sm-3">Materials</dt>
                                                            <dd class="col-sm-9">
                                                                @foreach ($request->materials as $material)
                                                                    <p>Material name: {{ $material->material_name }},</br>
                                                                        Material Weight: {{ $material->weight }}.</p>
                                                                @endforeach
                                                            </dd>

                                                            </dd>
                                                        </dl>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                        <!-- end show modal -->
                                    @endforeach
                                </table>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>




                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const select = document.getElementById('multiSelect');
                        const selectedValuesDiv = document.getElementById('selectedValues');

                        select.addEventListener('change', function() {
                            selectedValuesDiv.innerHTML = '';
                            Array.from(select.selectedOptions).forEach(option => {
                                const tag = document.createElement('span');
                                tag.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
                                tag.innerHTML =
                                    `${option.text} <span class="remove-tag" data-value="${option.value}">&times;</span>`;
                                selectedValuesDiv.appendChild(tag);
                            });
                        });

                        selectedValuesDiv.addEventListener('click', function(e) {
                            if (e.target.classList.contains('remove-tag')) {
                                const value = e.target.getAttribute('data-value');
                                const option = select.querySelector(`option[value="${value}"]`);
                                option.selected = false;
                                e.target.parentElement.remove();
                            }
                        });
                    });

                    document.addEventListener('DOMContentLoaded', function() {

                        const itemName = document.getElementById('itemName');
                        const itemWeight = document.getElementById('itemWeight');
                        const addButton = document.getElementById('addItem');
                        const itemList = document.getElementById('itemList');

                        const itemNames = [];
                        const itemWeights = [];

                        addButton.addEventListener('click', function() {
                            if (itemName.value && itemWeight.value) {
                                const itemDiv = document.createElement('div');
                                itemDiv.innerHTML = `
                        <span>${itemName.value} - ${itemWeight.value} kg</span>
                        <button class="removeItem">X</button>
                    `;
                                const nameInput = document.createElement('input');
                                nameInput.type = 'hidden';
                                nameInput.name = 'material_name[]';
                                nameInput.value = itemName.value;

                                const weightInput = document.createElement('input');
                                weightInput.type = 'hidden';
                                weightInput.name = 'weight[]';
                                weightInput.value = itemWeight.value;

                                itemDiv.appendChild(nameInput);
                                itemDiv.appendChild(weightInput);
                                itemList.appendChild(itemDiv);

                                itemName.value = '';
                                itemWeight.value = '';
                            }
                        });

                        itemList.addEventListener('click', function(e) {
                            if (e.target.classList.contains('removeItem')) {
                                const itemDiv = e.target.parentElement;

                                // Remove item from DOM
                                itemDiv.remove();
                            }
                        });
                    });
                </script>

                <script src="{{ asset('assets/js/vendor.min.js') }}"></script>



                <!-- Datatables js -->
                <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>


                <!-- Datatable Demo Aapp js -->
                <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

                <!-- App js -->
                <script src="{{ asset('assets/js/app.min.js') }}"></script>
            @endsection
