@extends('layouts.navigation')
@section('content')

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
                <!-- <h4 class="header-title mb-4">DIRECTOR PAGE</h4> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive"  id="table1">
                                        <div class="toggle-tables">
                                            <button type="button" class="btn btn-secondary rounded-pill" autofocus  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                            <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table2')">ARCHIVED REQUEST</button>
                                            <!-- Add more buttons for additional tables if needed -->
                                        </div></br>
                                        <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Requested By</th>
                                                    <th>Reason</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($Vehicle_Request->where('given_by', '==', null) as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->requestedBy->first_name}}</td>
                                                        <td>{{$request->purpose}}</td>
                                                        <td>{{$request->created_at}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal" id = "showInspectionModal" data-reason="{{$request->purpose}}" data-driving_license="{{$request->driving_license}}" data-position_letter="{{$request->position_letter}}" title="Show"><i class=" ri-eye-line"></i></button>
                                                            {{-- @if($request->approved_by === Null && $request->director_reject_reason === Null) --}}
                                                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#staticaccept-{{ $loop->index }}" title="accept"><i class=" ri-checkbox-circle-line"></i></button>
                                                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticreject-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>
                                                            {{-- @endif --}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <div class="modal fade" id="staticaccept-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <form method="POST" action="{{route('perm_vec_simirit_approve')}}">
                                                                @csrf   
                                                                <div class="modal-header">
                                                                        <div class="col-lg-6">
                                                                            <h5 class="mb-0">Select Vehicle</h5>
                                                                                <select name="vehicle_id" class="form-select" id="vehicleselection"  required>
                                                                                    <option value="" selected>Select</option>
                                                                                    @foreach ($Vehicle as $item)
                                                                                        <option value="{{$item->vehicle_id}}">{{$item->plate_number}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            <input type="hidden" name="request_id" value="{{$request->vehicle_request_permanent_id}}">
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

                                                 <!-- this is for the assign  modal -->
                                                 <div class="modal fade" id="staticreject-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Reject reason</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div> <!-- end modal header -->
                                                            <form method="POST" action="{{route('perm_vec_simirit_reject')}}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="col-lg-6">
                                                                        <h5 class="mb-3"></h5>
                                                                        <div class="form-floating">
                                                                        <input type="hidden" name="request_id" value="{{$request->vehicle_request_permanent_id}}">
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
                                        <div class="toggle-tables">
                                            <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                            <button type="button" class="btn btn-secondary rounded-pill"  onclick="toggleDiv('table2')">ARCHIVED REQUEST</button>
                                            <!-- Add more buttons for additional tables if needed -->
                                        </div></br>
                                        <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Requested By</th>
                                                    <th>Reason</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($Vehicle_Request->where('given_by', '!==', null) as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->requestedBy->first_name}}</td>
                                                        <td>{{$request->purpose}}</td>
                                                        <td>{{$request->created_at}}</td>
                                                        <td> @if($request->given_by !== null && $request->vec_director_reject_reason === null)
                                                                <p class="btn btn-primary ">ACCEPTED</p>
                                                             @elseif($request->given_by !== null && $request->vec_director_reject_reason !== null)
                                                                <p class="btn btn-danger">REJECTED
                                                            @endif
                                                        </td>
                                                        <td>
                                                        <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal" id = "showInspectionModal" data-reason="{{$request->purpose}}" data-driving_license="{{$request->driving_license}}" data-position_letter="{{$request->position_letter}}" title="Show"><i class=" ri-eye-line"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
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
            <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                aria-labelledby="standard-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Request Details</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-6">
                                <dl class="row mb-1">
                                    <dt class="col-sm-5">Request reason:</dt>
                                    <dd class="col-sm-7" id="reason"></dd>
                                </dl>
                            </div></br></br>
                            <div class="row">
                                <!-- Left Card -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Position Letter</h5>
                                        </div>
                                        <div class="card-body">
                                        <iframe id="image1" class="img-fluid" style="width: 100%; height: 100%;"></iframe>
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Right Card -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Driving License</h5>
                                        </div>
                                        <div class="card-body">
                                            <iframe id="image2" src="" alt="Driving License" class="img-fluid"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

    <script>
              document.getElementById('showInspectionModal').addEventListener('click', function() {
                Reason = $(this).data('reason');
                PositionLetter = $(this).data('position_letter');
                DrivingLicense = $(this).data('driving_license');

                // console.log(PositionLetter, DrivingLicense)

                // Construct file paths for the iframes
                const positionLetterPath = '/storage/PermanentVehicle/PositionLetter/' + PositionLetter;
                const drivingLicensePath = '/storage/PermanentVehicle/Driving_license/' + DrivingLicense;

                // Populate the iframes with the file paths
                $('#reason').text(Reason);
                $('#image1').attr('src', positionLetterPath);
                $('#image2').attr('src', drivingLicensePath);
              });
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
                    var imageUrl = Image ? "{{ asset('storage/vehicles/Inspections/') }}" + '/' + Image : null;    
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
                        <strong>Created At:</strong> ${createdAt}</br>
                        <strong>Image:</strong> 
                        ${ imageUrl 
                            ? `<a href="${imageUrl}" target="_blank"> Click to View </a>` 
                            : 'No image'
                        }
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
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

<!-- Datatables js -->
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        
<!-- Bootstrap Wizard Form js -->
<script src="{{ asset('assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

<!-- Wizard Form Demo js -->
<script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>

<!-- Datatable Demo Aapp js -->
<script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>    
@endsection
