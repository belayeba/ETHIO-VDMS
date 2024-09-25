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
                                <h4 class="header-title mb-4">NEW Transport Director REQUEST</h4>
                                <div class="toggle-tables">
                                    <button type="button" class="btn btn-secondary rounded-pill" autofocus  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table2')">ASSIGNED REQUEST</button>
                                    <!-- Add more buttons for additional tables if needed -->
                                </div></br>
                                <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Requested By</th>
                                            <th>Vehicle Type</th>
                                            <th>Location From</th>
                                            <th>Location To</th>
                                            <th>Purpose</th>
                                            <th>Requested At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach($vehicle_requests->where('assigned_by', '==', null) as $request)
                                        <tbody>
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$request->requestedBy->first_name}}</td>
                                                <td>{{$request->vehicle_type}}</td>
                                                <td>{{$request->start_location}}</td>
                                                <td>{{$request->end_locations}}</td>
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
                                                            var inspectedBy = response.data[0].inspected_by;
                                                            var createdAt = new Date(response.data[0].created_at).toLocaleDateString('en-US', {
                                                                year: 'numeric',
                                                                month: '2-digit',
                                                                day: '2-digit'
                                                            });
                                                        // Create a section to display "Inspected By" and "Created At" at the top right corner
                                                            var infoSection = document.createElement('div');
                                                            infoSection.className = 'd-flex justify-content-end mb-3'; // Flexbox to align right and add margin-bottom
                                                            infoSection.innerHTML = `
                                                                <p><strong>Inspected By:</strong> ${inspectedBy} </br>
                                                                <strong>Created At:</strong> ${createdAt}</p>
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
                                    @endforeach
                                </table>
                            </div>
                            <!-- end .table-responsive-->
                            <div class="table-responsive"  id="table2" style="display:none">
                                <h4 class="header-title mb-4" >ARCHIVED REQUEST</h4>
                                <div class="toggle-tables">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                    <button type="button" class="btn btn-secondary rounded-pill"  onclick="toggleDiv('table2')">ASSIGNED REQUEST</button>
                                    <!-- Add more buttons for additional tables if needed -->
                                </div></br>
                                <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Requested By</th>
                                            <th>Vehicle Type</th>
                                            <th>Location From</th>
                                            <th>Location To</th>
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
                                                <td>{{$request->start_location}}</td>
                                                <td>{{$request->end_locations}}</td>
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
                                                    @elseif($request->start_km !== null && $request->start_km == null)
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
                                        {{-- dispatch modal for the request --}}
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
                                        {{-- return modal for the request --}}
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
                                        {{-- end return modal --}}
                                    @endforeach
                                </table>
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
<script>


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
