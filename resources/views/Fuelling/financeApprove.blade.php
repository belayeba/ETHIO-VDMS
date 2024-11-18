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
                                       
                                        <table class="table director_datatable table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>Roll number</th>
                                                    <th>Requested By</th>
                                                    <th>Requested Month</th>
                                                    <th>Vehicle</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            {{-- @foreach($fuels as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->driver->user->first_name}}</td>
                                                        <td>{{$request->month}}/{{$request->year}}</td>
                                                        <td>{{$request->vehicle->plate_number}}</td>
                                                        <td>{{$request->finance_approved_by ? $request->financeApprover->first_name : "Not Approved Yet"}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill" title="Inspect" id="assignBtn-{{$loop->iteration}}">Show</button>
                                  
                                                            <input type="hidden" name="id" id="IdSelection-{{$loop->iteration}}" value="{{$request->fueling_id}}" id="vehicleselection">

                                                            <button id="acceptButton" type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#confirmationModal-{{$loop->iteration}}" title="Accept"><i class="ri-checkbox-circle-line"></i></button>
                                                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                                 <!-- this is for the assign  modal -->
                                                 <div class="modal fade" id="staticaccept-{{$loop->iteration}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            
                                                                <div class="modal-header">
                                                                                                                                    
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div> <!-- end modal header -->
                                                                <div class="modal-body d-flex flex-column align-items-center">
                                                                    <div class="row mt-3 w-100" id="inspectionCardsContainer-{{$loop->iteration}}">
                                                                    </div>
                                                                    
                                                                    <!-- Image Preview Section -->
                                                                    <div>
                                                                        <iframe id="filePreview-{{$loop->iteration}}" 
                                                                             style="width: 100%;
                                                                                    height: 500px; 
                                                                                    display: none;
                                                                                    ">
                                                                        </iframe>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">close</button>
                                                                </div> <!-- end modal footer -->
                                                            </div>                                                              
                                                        </div> <!-- end modal content-->
                                                    </div> <!-- end modal dialog-->

                                                   
                                                    
                                                    <script>
                                                        document.getElementById('assignBtn-{{$loop->iteration}}').addEventListener('click', function() {
                                                        var selectedCarId = document.getElementById('IdSelection-{{$loop->iteration}}').value;
                                                            
                                                            // Perform an Ajax request to fetch data based on the selected car ID
                                                            $.ajax({
                                                                url: '/show_detail/' + selectedCarId,
                                                                type: 'get',
                                                               
                                                                data: { id: selectedCarId },
                                                                success: function(response) {
                                                                    $('#staticaccept-{{$loop->iteration}}').modal('show');
                                                                    var cardsContainer = document.getElementById('inspectionCardsContainer-{{$loop->iteration}}');
                                                                    cardsContainer.innerHTML = ''; // Clear previous cards
                                                    
                                                                    if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                                                                        // Create the table
                                                                       
                                                                    // Create a section to display "Inspected By" and "Created At" at the top right corner
                                                                        var infoSection = document.createElement('div');
                                                                        cardsContainer.appendChild(infoSection); // Append the info section before the table
                                                    
                                                                        var table = document.createElement('table');
                                                                        table.className = 'table table-striped'; // Add Bootstrap classes for styling
                                                                        table.innerHTML = `
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Roll no</th>
                                                                                    <th>Fuel Ammount</th>
                                                                                    <th>Fuel Cost</th>
                                                                                    <th>Fueling Date</th>
                                                                                    <th>Receit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        `;
                                                                            
                                                                       var count = 0;
                                                                        response.data.forEach(function(fueling,index) {
                                                                            var row = document.createElement('tr');
                                                                             count = count +1;
                                                                            row.innerHTML = `
                                                                                <td>${count}</td>
                                                                                <td>${fueling.fuel_amount}</td>
                                                                                <td>${fueling.fuel_cost}</td>
                                                                                <td>${fueling.fuiling_date }</td>
                                                                                <td>
                                                                                   <a href="javascript:void(0);" onclick="showFileInIframe('{{ asset('storage/vehicles/reciept/') }}/${fueling.reciet_attachment}', '{{$loop->iteration}}')">
                                                                                        ${fueling.reciet_attachment}
                                                                                    </a>
                                                                                </td>
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

                                                        function showFileInIframe(fileUrl, iteration) {
                                                            var filePreview = document.getElementById('filePreview-' + iteration);
                                                            filePreview.src = fileUrl;  // Set the file URL to the iframe's src
                                                            filePreview.style.display = 'block';  // Display the iframe
                                                        }
                                                    </script>
                                            @endforeach --}}
                                        </table>
                                    </div>
                                    {{-- modal for displaying the data --}}
                                    <div class="modal fade" id="staticaccept" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                
                                                    <div class="modal-header">
                                                                                                                        
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div> <!-- end modal header -->
                                                    <div class="modal-body d-flex flex-column align-items-center">
                                                        <div class="row mt-3 w-100" id="inspectionCardsContainer">
                                                        </div>
                                                        
                                                        <!-- Image Preview Section -->
                                                        <div>
                                                            <iframe id="filePreview" 
                                                                 style="width: 100%;
                                                                        height: 500px; 
                                                                        display: none;
                                                                        ">
                                                            </iframe>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">close</button>
                                                    </div> <!-- end modal footer -->
                                                </div>                                                              
                                            </div> <!-- end modal content-->
                                        </div> <!-- end modal dialog-->

                                          <!-- Accept Alert Modal -->
                                          <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <form method="POST" id="approvalForm" action="">
                                                        @csrf
                                                        {{-- {{route('finance_approve',['id'=>$request->fueling_id ])}} --}}
                                                        <div class="modal-body p-4">
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-warning"></i>
                                                                <h4 class="mt-2">Warning</h4>
                                                                <h5 class="mt-3">
                                                                    Are you sure you want to approve this request?</br> This action
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

                                         <!-- this is for the assign  modal -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Reject reason
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div> <!-- end modal header -->
                                                    <form method="POST" id="RejectForm" action="">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="col-lg-6">
                                                                <h5 class="mb-3"></h5>
                                                                <div class="form-floating">
                                                                    <input type="hidden" name="request_id"
                                                                        id="Reject_request_id">
                                                                    <textarea class="form-control" name="reason" style="height: 60px;" required></textarea>
                                                                    <label for="floatingTextarea">Reason</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div> <!-- end modal footer -->
                                                    </form>
                                                </div> <!-- end modal content-->
                                            </div> <!-- end modal dialog-->
                                        </div>
                                        <!-- end assign modal -->

                                    <!-- end .table-responsive-->
                                   
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
  
  var table = $('.director_datatable').DataTable({
            processing: true,
            pageLength: 3,
            serverSide: true,
            ajax: "{{ route('finance_page_fetch') }}",
            columns: [{
                    data: 'counter',
                    name: 'counter'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'Request',
                    name: 'Request'
                },
                {
                    data: 'vehicle',
                    name: 'vehicle'
                },
                {
                    data: 'approver',
                    name: 'approver'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });


        $(document).on('click', '.view-btn', function() {
        // Get the request ID from the data attribute
        var selectedCarId = $(this).data('id');

    // Perform the Ajax request to fetch data based on the selected car ID
    $.ajax({
        url: '/show_detail/' + selectedCarId,
        type: 'get',
        data: { id: selectedCarId },
        success: function(response) {
            $('#staticaccept').modal('show');

             // Clear previous cards and image preview
            var cardsContainer = $('#inspectionCardsContainer');
            cardsContainer.empty(); 
            clearFilePreview(); 

            if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                // Populate the table and info section
                var table = $('<table class="table table-striped">').append(`
                    <thead>
                        <tr>
                            <th>Roll no</th>
                            <th>Fuel Amount</th>
                            <th>Fuel Cost</th>
                            <th>Fueling Date</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                `);

                var count = 0;
                response.data.forEach(function(fueling) {
                    count++;
                    var row = $(`
                        <tr>
                            <td>${count}</td>
                            <td>${fueling.fuel_amount}</td>
                            <td>${fueling.fuel_cost}</td>
                            <td>${fueling.fuiling_date}</td>
                            <td>
                                <a href="javascript:void(0);" onclick="showFileInIframe('{{ asset('storage/vehicles/reciept/') }}/${fueling.reciet_attachment}')">
                                    ${fueling.reciet_attachment}
                                </a>
                            </td>
                        </tr>
                    `);
                    table.find('tbody').append(row);
                });

                cardsContainer.append(table);
            } else {
                cardsContainer.html('<p>No inspection data available.</p>');
            }
        },
        error: function() {
            var cardsContainer = $('#inspectionCardsContainer');
            cardsContainer.html('<p>No inspection data available at the moment. Please check the Plate number!</p>');
        }
    });
});

function showFileInIframe(fileUrl) {
    clearFilePreview(); 
    var filePreview = document.getElementById('filePreview');
    filePreview.src = fileUrl; // Set the file URL to the iframe's src
    filePreview.style.display = 'block'; // Display the iframe
}

function clearFilePreview() {
    var filePreview = document.getElementById('filePreview');
    filePreview.src = ''; // Clear the src to "erase" the previous image
    filePreview.style.display = 'none'; // Optionally hide the iframe
}

    
        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.accept-btn', function() {
                var AcceptedId = $(this).data('id');
        
                
                var actionUrl = "{{ route('finance_approve', ['id' => ':id']) }}";
                actionUrl = actionUrl.replace(':id', AcceptedId);
                
                $('#approvalForm').attr('action', actionUrl);
                        $('#confirmationModal').modal('show');
                    });
        });

        $(document).ready(function() {
            $(document).on('click', '.reject-btn', function() {
               var RejectedId = $(this).data('id');
                           
                var actionUrl = "{{ route('finance_reject', ['id' => ':id']) }}";
                actionUrl = actionUrl.replace(':id', RejectedId);
                
                $('#RejectForm').attr('action', actionUrl);
                
                        $('#staticBackdrop').modal('show');
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
