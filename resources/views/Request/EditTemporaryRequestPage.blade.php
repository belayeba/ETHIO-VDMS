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
                        <h4 class="header-title">Request Vehicle</h4>
                    </div>
                    <div class="card-body"> 
                        <form method="POST" action="{{route('temp_update_request')}}">
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
                                                    data-date-container="#datepicker1" value="{{$Requested->purpose}}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="request_id" class="form-control" value="{{$Requested->request_id}}">
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Vehicle type</label>
                                                <input type="text" class="form-control" name="vehicle_type" placeholder="Select vehicle type"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1" value="{{$Requested->vehicle_type}}">
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
                                                    data-date-container="#datepicker1" value="{{$Requested->start_date}}">
                                            </div>
                                        </div>
                            
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Start Time</label>
                                                <input type="time" class="form-control" name="start_time" placeholder="Enter Time of departure"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1" value="{{\Carbon\Carbon::parse($Requested->start_time)->format('H:i')}}">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Return Date</label>
                                                <input type="date" class="form-control" name="return_date" placeholder="Enter Date of arrival"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1" value="{{$Requested->end_date}}">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Return Time</label>
                                                <input type="time" class="form-control" name="return_time" placeholder="Enter Time of arrival"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1" value="{{\Carbon\Carbon::parse($Requested->end_time)->format('H:i')}}">
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
                                                    data-date-container="#datepicker1" value="{{$Requested->start_location}}">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Location to</label>
                                                <input type="text" class="form-control" name="end_location" placeholder="Enter arrival location"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1" value="{{$Requested->end_locations}}">
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
                                        <p class="text-danger  small">Kindly Add the passenger and materials.</p>
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
                <div class="card-header">
                    <h4>Previous request data</h4>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Request reason</dt>
                        <dd class="col-sm-9">{{$Requested->purpose}}.</dd>

                        <dt class="col-sm-3">Requested vehicle</dt>
                        <dd class="col-sm-9">
                            <p>{{$Requested->vehicle_type}}.</p>
                        </dd>

                        <dt class="col-sm-3">Start date and Time</dt>
                        <dd class="col-sm-9">{{$Requested->start_date}}, {{$Requested->start_time}}.</dd>

                        <dt class="col-sm-3">Return date and Time</dt>
                        <dd class="col-sm-9">{{$Requested->end_date}}, {{$Requested->end_time}}.</dd>

                        <dt class="col-sm-3">Location From and To</dt>
                        <dd class="col-sm-9">{{$Requested->start_location}}, {{$Requested->end_locations}}.</dd>

                        <dt class="col-sm-3 text-truncate">passenger</dt>
                       
                        <dd class="col-sm-9">  @foreach($Requested->peoples as $person) {{$person->user->first_name}}.</br> @endforeach</dd>

                        <dt class="col-sm-3">Materials</dt>
                        <dd class="col-sm-9">
                            @foreach($Requested->materials as $material)
                                <p>Material name: {{ $material->material_name }},</br> Material Weight: {{ $material->weight }}</p>
                            @endforeach.</dd>
                         
                        </dd>
                    </dl>  
                </div> <!-- end card body-->
            </div> <!-- end card -->
    </div><!-- end col-->
</div> 
</div>
</div>

    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Text in a modal</h5>
                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                    <hr>
                    <h5>Overflowing text to show scroll behavior</h5>
                    <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                    <p class="mb-0">Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('multiSelect');
            const selectedValuesDiv = document.getElementById('selectedValues');

            select.addEventListener('change', function() {
                selectedValuesDiv.innerHTML = '';
                Array.from(select.selectedOptions).forEach(option => {
                    const tag = document.createElement('span');
                    tag.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
                    tag.innerHTML = `${option.text} <span class="remove-tag" data-value="${option.value}">&times;</span>`;
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
