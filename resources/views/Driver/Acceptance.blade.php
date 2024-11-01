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
                                        <h4 class="header-title mb-4">NEW REQUEST</h4>
                                        <div class="toggle-tables">
                                            <button type="button" class="btn btn-secondary rounded-pill" autofocus  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                            <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table2')">ARCHIVED REQUEST</button>
                                            <!-- Add more buttons for additional tables if needed -->
                                        </div></br>
                                        <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Vehicle</th>
                                                    <th>New Driver</th>
                                                    <th>Old Driver</th>
                                                    <th>Inspection</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($get_request->where('dir_approved_by', '===', null) as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td id="plate">{{$request->vehicle->plate_number}}</td>
                                                        <td>{{$request->newDriver->user->first_name}}</td>
                                                        <td>{{$request->oldDriver->user->first_name}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-secondary"  id="assignBtn">Get Inspection</button>
                                                        </td>
                                                        {{-- <td>{{$request->created_at}}</td> --}}
                                                        {{-- <td>
                                                            <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="Show"><i class=" ri-eye-line"></i></button>
                                                            @if($request->dir_approved_by === Null && $request->director_reject_reason === Null)
                                                            <button id="acceptButton" type="button" class="btn btn-primary rounded-pill" title="Accept" onclick="confirmFormSubmission('approvalForm-{{ $loop->index }}')"><i class="ri-checkbox-circle-line"></i></button>
                                                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>
                                                            @endif
                                                        </td> --}}
                                                    </tr>
                                                </tbody>
                                                <form id="approvalForm-{{ $loop->index }}" method="POST" action="{{ route('director_approve_request') }}" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="request_id" value="{{ $request->request_id }}">
                                                </form>
                                                @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        
                                            
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

<script>
document.getElementById('assignBtn').addEventListener('click', function() {
    // Check if vehicleselection exists
    var vehicleSelectionElement = document.getElementById('vehicleselection');
    var selectedCarId = vehicleSelectionElement ? vehicleSelectionElement.value : "vehicleselection not found";
    console.log("Selected Car ID:", selectedCarId);

    // Check if Gridinline-editableView2 exists
    var container = document.getElementById("Gridinline-editableView2");
    if (container) {
        // Attempt to get the specific <td> content if it exists
        var vehicleTd = container.getElementsByTagName("td")[2];
        var vehicle = vehicleTd ? vehicleTd.textContent.trim() : "No <td> found at index 2";
        console.log("Vehicle:", vehicle);
    } else {
        console.log("Gridinline-editableView2 container not found");
    }
// });



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
