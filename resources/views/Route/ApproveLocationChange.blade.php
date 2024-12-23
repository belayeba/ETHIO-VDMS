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
                                                    <th>Location</th>
                                                    <th>Requested At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($Requests->where('changed_by', '==', null) as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->registeredBy->first_name}}</td>
                                                        <td>{{$request->location_name}}</td>
                                                        <td>{{$request->created_at->format('Y-m-j')}}</td>
                                                        <td>@if($request->changed_by === Null )
                                                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#staticaccept-{{ $loop->index }}" title="accept"><i class=" ri-checkbox-circle-line"></i></button>
                                                        <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <form id="approvalForm-{{ $loop->index }}" method="POST" action="{{ route('vehicle_director_approve_request') }}" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="request_id" value="{{ $request->giving_back_vehicle_id }}">
                                                </form>
                                                
                                                <!-- this is for the Reject  modal -->
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
                                                    <th>Location</th>
                                                    <th>Requested At</th>
                                                </tr>
                                            </thead>
                                            @foreach($Requests->where('changed_by', '!==', null) as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->registeredBy->first_name}}</td>
                                                        <td>{{$request->location_name}}</td>
                                                        <td>{{$request->created_at}}</td>
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
         <!-- this is for the assign  modal -->
                           <div class="modal fade" id="showInspection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                     
                                        <div class="modal-header">
                                                                                                            
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div> <!-- end modal header -->
                                        <div class="modal-body">
                                            <div class="row mt-3" id="inspectionCardsContainer" class="table table-striped"> 
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">close</button>
                                        </div> <!-- end modal footer -->
                                    </div>                                                              
                                </div> <!-- end modal content-->
                            </div> <!-- end modal dialog-->
                <script>
              document.getElementById('showInspectionModal').addEventListener('click', function() {
            var inspection = this.getAttribute('data-value');                                
            // Perform an Ajax request to fetch data based on the selected car ID
            $.ajax({
                url: "{{ route('inspection.show.specific') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: { id: inspection },
                success: function(response) {
                    $('#showInspection').modal('show');
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
                        infoSection.className = 'd-flex justify-content-end mb-4'; // Flexbox to align right and add margin-bottom
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
                        var h1 = document.createElement('h4');
                        h1.style.textAlign = 'center';
                        h1.innerHTML = 'Vehilce parts';
                        var h2 = document.createElement('h4');
                        h2.style.textAlign = 'center';
                        h2.innerHTML = 'Spare parts';
                        var table = document.createElement('table');
                        table.className = 'table table-striped'; // Add Bootstrap classes for styling
                        table.innerHTML = `
                            <thead>
                                <tr>
                                    <th>Vehicle Part</th>
                                    <th>Is Damaged</th>
                                    <th>Damage Description</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        `;
    
                        response.data.forEach(function(inspection) {
                            if(inspection.type == 'normal_part')
                                {
                                    var row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${inspection.part_name}</td>
                                        <td>${inspection.is_damaged ? 'No' : 'Yes'}</td>
                                        <td>${inspection.damage_description ? inspection.damage_description : '-'}</td>
                                    `;
                                    table.querySelector('tbody').appendChild(row); // Append row to the table body
                                }
                        });
                        cardsContainer.appendChild(h1);
                        cardsContainer.appendChild(table);

                        var table1 = document.createElement('table');
                        table1.className = 'table table-striped'; // Add Bootstrap classes for styling
                        table1.innerHTML = `
                            <thead>
                                <tr>
                                    <th>Spare part</th>
                                    <th>Is available</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        `;
    
                        response.data.forEach(function(inspection) {
                            if(inspection.type == 'spare_part')
                                {
                                    var row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${inspection.part_name}</td>
                                        <td>${inspection.is_damaged == "0" ? 'No' : 'Yes'}</td>
                                        <td>${inspection.damage_description ? inspection.damage_description : '-'}</td>
                                    `;
                                    table1.querySelector('tbody').appendChild(row); // Append row to the table body
                                }
                        });
                        cardsContainer.appendChild(h2);
                        cardsContainer.appendChild(table1);
    
                    } 
                else 
                    {
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
