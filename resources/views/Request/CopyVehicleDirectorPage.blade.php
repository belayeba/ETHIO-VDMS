@extends('layouts.navigation')
@section('content')


<div class="content-page">
    <div class="content">

        <!-- <h4 class="header-title mb-4">DIRECTOR PAGE</h4> -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive"  id="table1">
                                <h4 class="header-title mb-4">Dispathcer REQUEST</h4>
                                    <div class="dropdown btn-group">
                                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownButton">
                                            ALL
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-animated">
                                            <a class="dropdown-item" onclick="updateState(1, 'PENDING')">PENDING</a>
                                            <a class="dropdown-item" onclick="updateState(2, 'ASSIGNED')">ASSIGNED</a>
                                            <a class="dropdown-item" onclick="updateState(3, 'DISPATCHED')">DISPATCHED</a>
                                        </div>
                                    </div>
                                    {{-- <button type="button" class="btn btn-secondary rounded-pill" autofocus onclick="updateState(1)">PENDING REQUEST</button>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="updateState(2)">ASSIGNED REQUEST</button> --}}
                                <div class="toggle-tables">
                                    {{-- <button type="button" class="btn btn-secondary rounded-pill" autofocus onclick="updateState(1)">PENDING REQUEST</button>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="updateState(2)">ASSIGNED REQUEST</button> --}}
                                    <!-- Add more buttons for additional tables if needed -->
                                </div></br>
                                <table class="table dispatcher_datatable table-centered mb-0 table-nowrap" id="inline-editable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Requested By</th>
                                            <th>Vehicle Type</th>
                                            <th>Purpose</th>
                                            <th>Requested At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- @foreach($vehicle_requests->where('assigned_by', '==', null) as $request)
                                        <tbody>
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$request->requestedBy->first_name}}</td>
                                                <td>{{$request->vehicle_type}}</td>
                                                <td>{{$request->purpose}}</td>
                                                <td>{{$request->created_at}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="show"><i class=" ri-eye-line"></i></button>
                                                    @if($request->assigned_by == null)
                                                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#staticaccept-{{ $loop->index }}" title="accept"><i class=" ri-checkbox-circle-line"></i></button>
                                                    <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticreject-{{ $loop->index }}" title="reject"><i class=" ri-close-circle-fill"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>

                                        <!-- show all the information about the request modal -->
                                        <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Request Details</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-3">Request reason</dt>
                                                            <dd class="col-sm-9">{{$request->purpose}}.</dd>

                                                            <dt class="col-sm-3">Request status</dt>
                                                            <dd class="col-sm-9">{{$request->status}}.</dd>

                                                            <dt class="col-sm-3">Requested vehicle</dt>
                                                            <dd class="col-sm-9">
                                                                <p>{{$request->vehicle_type}}.</p>
                                                            </dd>

                                                            <dt class="col-sm-3">Start date and Time</dt>
                                                            <dd class="col-sm-9">{{$request->start_date}}, {{$request->start_time}}.</dd>

                                                            <dt class="col-sm-3">Return date and Time</dt>
                                                            <dd class="col-sm-9">{{$request->end_date}}, {{$request->end_time}}.</dd>

                                                            <dt class="col-sm-3">Location From and To</dt>
                                                            <dd class="col-sm-9">{{$request->start_location}}, {{$request->end_locations}}.</dd>

                                                            <dt class="col-sm-3 text-truncate">passenger</dt>
                                                        
                                                            <dd class="col-sm-9">  @foreach($request->peoples as $person) {{$person->user->first_name}}.</br> @endforeach</dd>

                                                            <dt class="col-sm-3">Materials</dt>
                                                            <dd class="col-sm-9">
                                                                @foreach($request->materials as $material)
                                                                    <p>Material name: {{ $material->material_name }},</br> Material Weight: {{ $material->weight }}.</p>
                                                                @endforeach</dd>
                                                            
                                                            </dd>
                                                        </dl>  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                                                        <form >
                                                            
                                                            <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                            <div class="form-floating"  id="vehicleselect" style="display:none">
                                                                <select class="form-select" id="floatingSelect"
                                                                    aria-label="Floating label select example">
                                                                    <option selected>Vehicles</option>
                                                                    <option value="1">One</option>
                                                                    <option value="2">Two</option>
                                                                    <option value="3">Three</option>
                                                                </select>
                                                                <label for="floatingSelect">Select a Vehicle</label>
                                                            </div>  
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                        <!-- end show modal -->
                                        <!-- this is for the assign  modal -->
                                        <div class="modal fade" id="staticaccept-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{route('simirit_approve')}}">
                                                        @csrf   
                                                        <div class="modal-header">
                                                                <div class="col-lg-6">
                                                                    <h5 class="mb-0">Select Vehicle</h5>
                                                                        <select name="assigned_vehicle_id" class="form-select" id="vehicleselection"  required>
                                                                            <option value="" selected>Select</option>
                                                                            @foreach ($vehicles as $item)
                                                                                <option value="{{$item->vehicle_id}}">{{$item->plate_number}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                                </div>                                                               
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div> <!-- end modal header -->
                                                        <div class="modal-body">
                                                            <div class="row mt-3" id="inspectionCardsContainer" class="table table-striped"> 
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"  id="assignBtn">Get Inspection</button>
                                                            <button type="submit" class="btn btn-primary">Assign</button>
                                                        </div> <!-- end modal footer -->
                                                    </form>                                                                    
                                                </div> <!-- end modal content-->
                                            </div> <!-- end modal dialog-->
                                        </div>
                                        <script>
                                            document.getElementById('assignBtn').addEventListener('click', function() {
                                            var selectedCarId = document.getElementById('vehicleselection').value;
                                                
                                                // Perform an Ajax request to fetch data based on the selected car ID
                                                $.ajax({
                                                    url: "{{ route('inspection.ByVehicle') }}",
                                                    type: 'GET',
                                                    data: { id: selectedCarId },
                                                    success: function(response) {
                                                        var cardsContainer = document.getElementById('inspectionCardsContainer');
                                                        cardsContainer.innerHTML = ''; // Clear previous cards

                                                        if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                                                            // Create the table
                                                            var Image = response.data[0].image_path;
                                                            var inspectedBy = response.data[0].inspected_by;
                                                            var createdAt = new Date(response.data[0].created_at).toLocaleDateString('en-US', {
                                                                year: 'numeric',
                                                                month: '2-digit',
                                                                day: '2-digit'
                                                            });
                                                        // Create a section to display "Inspected By" and "Created At" at the top right corner
                                                            var infoSection = document.createElement('div');
                                                            infoSection.className = 'd-flex justify-content-end mb-4'; // Flexbox to align right and add margin-bottom
                                                            infoSection.innerHTML = `
                                                                <p><strong>Inspected By:</strong> ${inspectedBy} </br>
                                                                <strong>Created At:</strong> ${createdAt}</br>
                                                                <strong>Image:</strong> ${Image}</p>
                                                            `;
                                                            cardsContainer.appendChild(infoSection); // Append the info section before the table

                                                            var table = document.createElement('table');
                                                            table.className = 'table table-striped'; // Add Bootstrap classes for styling
                                                            table.innerHTML = `
                                                                <thead>
                                                                    <tr>
                                                                        <th>Part Name</th>
                                                                        <th>Is Damaged</th>
                                                                        <th>Damage Description</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            `;

                                                            response.data.forEach(function(inspection) {
                                                                var row = document.createElement('tr');
                                                                row.innerHTML = `
                                                                    <td>${inspection.part_name}</td>
                                                                    <td>${inspection.is_damaged ? 'No' : 'Yes'}</td>
                                                                    <td>${inspection.damage_description ? inspection.damage_description : 'N/A'}</td>
                                                                `;
                                                                table.querySelector('tbody').appendChild(row); // Append row to the table body
                                                            });

                                                            cardsContainer.appendChild(table);

                                                        } else {
                                                            // Handle the case where no data is available
                                                            cardsContainer.innerHTML = '<p>No inspection data available.</p>';
                                                        }
                                                    },
                                                    error: function() {
                                                        var cardsContainer = document.getElementById('inspectionCardsContainer');
                                                        cardsContainer.innerHTML = ''; // Clear previous cards
                                                        cardsContainer.innerHTML = '<p>No inspection data available at the moment. Please check the Plate number!</p>';
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- end assign modal -->
                                        <!-- this is for the assign  modal -->
                                        <div class="modal fade" id="staticreject-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Reject request</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div> <!-- end modal header -->
                                                    <form method="POST" action="{{route('simirit_reject')}}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="col-lg-6">
                                                                <h5 class="mb-3"></h5>
                                                                <div class="form-floating">
                                                                <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                                <textarea class="form-control" name="reason" style="height: 60px;" required></textarea>
                                                                <label for="floatingTextarea">Reason</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div> <!-- end modal footer -->
                                                    </form>                                                                    
                                                </div> <!-- end modal content-->
                                            </div> <!-- end modal dialog-->
                                        </div>
                                        <!-- end assign modal -->
                                    @endforeach --}}
                                    <tbody></tbody>
                                </table>
                            </div>
                             <!-- show all the information about the request modal -->
                             <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                             aria-labelledby="standard-modalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h4 class="modal-title">Request Details</h4>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                         <dl class="row mb-0">
                                             <dt class="col-sm-5">Request reason</dt>
                                             <dd class="col-sm-7" data-field="purpose"></dd>

                                             <dt class="col-sm-5">Requested vehicle</dt>
                                             <dd class="col-sm-7" data-field="vehicle_type"></dd>

                                             <dt class="col-sm-5">Start date and Time</dt>
                                             <dd class="col-sm-7" data-field="start_date"></dd>

                                             <dt class="col-sm-5">Return date and Time</dt>
                                             <dd class="col-sm-7" data-field="end_date"></dd>

                                             <dt class="col-sm-5">Location From and To</dt>
                                             <dd class="col-sm-7" data-field="start_location"></dd>

                                             <dt class="col-sm-5">Passengers</dt>
                                             <dd class="col-sm-7" data-field="passengers"></dd>

                                             <dt class="col-sm-5">Materials</dt>
                                             <dd class="col-sm-7" data-field="materials"></dd>

                                             <dt class="col-sm-5">Progress</dt>
                                             <dd class="col-sm-7" data-field="progress"></dd>
                                         </dl>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-light"
                                             data-bs-dismiss="modal">Close</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!-- end show modal -->

                            <!-- end .table-responsive-->
                            <div class="table-responsive"  id="table2" style="display:none">
                                <h4 class="header-title mb-4" >ARCHIVED REQUEST</h4>
                                <div class="toggle-tables">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                    <button type="button" class="btn btn-secondary rounded-pill"  onclick="toggleDiv('table2')">ASSIGNED REQUEST</button>
                                    <!-- Add more buttons for additional tables if needed -->
                                </div></br>
                                {{-- <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Requested By</th>
                                            <th>Vehicle Type</th>
                                            <th>Requested At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($vehicle_requests->where('assigned_by', '!==', null) as $request)
                                        <tbody>
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$request->requestedBy->first_name}}</td>
                                                <td>{{$request->vehicle_type}}</td>
                                                <td>{{$request->created_at}}</td>
                                                <td> @if($request->vehicle_id !== null && $request->start_km == null)
                                                        <p class="text-primary ">ASSIGNED</p>
                                                     @elseif($request->end_km == null && $request->start_km !== null)
                                                        <p class="text-primary">DISPATCHED
                                                    @elseif($request->start_km !== null && $request->end_km !== null)
                                                        <p class="text-primary">RETURNED
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#archived-modal-{{ $loop->index }}" title="Show"><i class=" ri-eye-line"></i></button>
                                                    @if($request->start_km == null)
                                                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#staticdispatch-{{ $loop->index }}" title="Dispatch"><i class="  ri-contract-right-fill"></i></button>
                                                    @elseif($request->start_km !== null && $request->end_km == null)
                                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#staticreturn-{{ $loop->index }}" title="Return"><i class="  ri-contract-left-fill"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                           
                                        <!-- show all the information about the request modal -->
                                        <div id="archived-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Request Details</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-3">Request reason</dt>
                                                            <dd class="col-sm-9">{{$request->purpose}}.</dd>

                                                            <dt class="col-sm-3">Requested vehicle</dt>
                                                            <dd class="col-sm-9">
                                                                <p>{{$request->vehicle_type}}.</p>
                                                            </dd>

                                                            <dt class="col-sm-3">Start date and Time</dt>
                                                            <dd class="col-sm-9">{{$request->start_date}}, {{$request->start_time}}.</dd>

                                                            <dt class="col-sm-3">Return date and Time</dt>
                                                            <dd class="col-sm-9">{{$request->end_date}}, {{$request->end_time}}.</dd>

                                                            <dt class="col-sm-3">Location From and To</dt>
                                                            <dd class="col-sm-9">{{$request->start_location}}, {{$request->end_locations}}.</dd>

                                                            <dt class="col-sm-3 text-truncate">passenger</dt>
                                                        
                                                            <dd class="col-sm-9">  @foreach($request->peoples as $person) {{$person->user->first_name}}.</br> @endforeach</dd>

                                                            <dt class="col-sm-3">Materials</dt>
                                                            <dd class="col-sm-9">
                                                                @foreach($request->materials as $material)
                                                                    <p>Material name: {{ $material->material_name }},</br> Material Weight: {{ $material->weight }}.</p>
                                                                @endforeach</dd>
                                                            
                                                            </dd>
                                                        </dl>  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                        <!-- end show modal -->
                                        dispatch modal for the request
                                        <div class="modal fade" id="staticdispatch-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="staticBackdropLabel">Assigned Vehicle</h4>&nbsp;&nbsp;
                                                        <h3  class="text-info">{{$request->vehicle->plate_number}}</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div> <!-- end modal header -->
                                                    <form method="POST" action="{{route('simirit_fill_start_km')}}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-6 position-relative">
                                                                <label class="form-label">Start KM</label>
                                                                <input type="number" class="form-control" name="start_km"
                                                                    placeholder="Enter Initial KM">
                                                            </div>
                                                            <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Dispatch</button>
                                                        </div> <!-- end modal footer -->
                                                    </form>                                                                    
                                                </div> <!-- end modal content-->
                                            </div> <!-- end modal dialog-->
                                        </div>
                                        {{-- end dispatch modal --}}
                                        {{-- return modal for the request 
                                        <div class="modal fade" id="staticreturn-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="staticBackdropLabel">Assigned Vehicle</h4>&nbsp;&nbsp;
                                                        <h3  class="text-info">{{$request->vehicle->plate_number}}</h3>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div> <!-- end modal header -->
                                                    <form method="POST" action="{{route('simirit_return_vehicle')}}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-6 position-relative">
                                                                <label class="form-label">End KM</label>
                                                                <input type="number" class="form-control" name="end_km"
                                                                    placeholder="Enter Return KM">
                                                            </div>
                                                            <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-warning">Return</button>
                                                        </div> <!-- end modal footer -->
                                                    </form>                                                                    
                                                </div> <!-- end modal content-->
                                            </div> <!-- end modal dialog-->
                                        </div>
                                        {{-- end return modal 
                                    @endforeach
                                </table> --}}
                            </div> 
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content --> 

    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<script>

let customDataValue = 1;


function updateState(value, buttonText) {
    document.getElementById('dropdownButton').innerText = buttonText;
    customDataValue = value; 
    table.ajax.reload();
}

var table = $('.dispatcher_datatable').DataTable({
            processing: true,
            pageLength: 5,
            serverSide: true,
            ajax: {
                    url: "{{ route('FetchForDispatcher') }}",
                    data: function (d) {
                        d.customDataValue = customDataValue;
                    }
                },         
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

        $('#standard-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modal = $(this); // The modal

            // Populate basic request details
            modal.find('.modal-title').text('Request Details');
            modal.find('[data-field="purpose"]').text(button.data('purpose'));
            modal.find('[data-field="vehicle_type"]').text(button.data('vehicle_type'));
            modal.find('[data-field="start_date"]').text(button.data('start_date') + ', ' + button.data(
                'start_time'));
            modal.find('[data-field="end_date"]').text(button.data('end_date') + ', ' + button.data('end_time'));
            modal.find('[data-field="start_location"]').text(button.data('start_location'));
            modal.find('[data-field="end_locations"]').text(button.data('end_locations'));

            // Populate passengers
            var passengers = button.data('passengers');
            var passengerList = '';
            if (passengers) {
                passengers.forEach(function(person) {
                    passengerList += person.user.first_name + '<br>';
                });
            }
            modal.find('[data-field="passengers"]').html(passengerList);

            // Populate materials
            var materials = button.data('materials');
            var materialList = '';
            if (materials) {
                materials.forEach(function(material) {
                    materialList += 'Material name: ' + material.material_name + ',<br>' +
                        'Material Weight: ' + material.weight + '.<br>';
                });
            }
            modal.find('[data-field="materials"]').html(materialList);

            // Function to build progress messages
            function buildProgressMessage(button) {
                let progressMessages = [];

                const messages = [{
                        condition: button.data('dir_approved_by'),
                        message: 'Approved by Director'
                    },
                    {
                        condition: button.data('director_reject_reason'),
                        message: 'Rejected by Director'
                    },
                    {
                        condition: button.data('div_approved_by'),
                        message: 'Approved by Division-Director'
                    },
                    {
                        condition: button.data('cluster_director_reject_reason'),
                        message: 'Rejected by Division-Director'
                    },
                    {
                        condition: button.data('hr_div_approved_by'),
                        message: 'Approved by HR-Director'
                    },
                    {
                        condition: button.data('hr_director_reject_reason'),
                        message: 'Rejected by HR-Director'
                    },
                    {
                        condition: button.data('transport_director_id'),
                        message: 'Approved by Dispatcher-Director'
                    },
                    {
                        condition: button.data('vec_director_reject_reason'),
                        message: 'Rejected by Dispatcher-Director'
                    },
                    {
                        condition: button.data('assigned_by'),
                        message: 'Approved by Dispatcher'
                    },
                    {
                        condition: button.data('assigned_by_reject_reason'),
                        message: 'Rejected by Dispatcher'
                    },
                    {
                        condition: button.data('vehicle_id'),
                        message: 'Assigned Vehicle <u>' + button.data('vehicle_plate') + '</u>'
                    },
                    {
                        condition: button.data('start_km'),
                        message: 'Vehicle Request <u>' + button.data('vehicle_plate') + '</u> Dispatched'
                    },
                    {
                        condition: button.data('end_km'),
                        message: 'Request completed'
                    },
                ];
                messages.forEach(item => {
                    if (item.condition) {
                        progressMessages.push(item.message);
                    }
                });

                // If no conditions were met, set progress to 'Pending'
                let progress = progressMessages.length > 0 ? progressMessages.join('<br>') : 'Pending';



                return progress;
            }

            // Populate progress
            modal.find('[data-field="progress"]').html(buildProgressMessage(button));

        });

function confirmFormSubmission(formId) {
if (confirm("Are you sure you want to accept this request?")) {
    var form = document.getElementById(formId);
    form.submit();
}
}

function toggleDiv(targetId) {
const allDivs = document.querySelectorAll('.table-responsive');
allDivs.forEach(div => {
    if (div.id === targetId) {
        div.style.display = 'block';// Show the target div
    } else {
        div.style.display = 'none';// Hide other divs
    }
});
}
</script>
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>    
@endsection
