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
                                            
                                            <div class="dropdown btn-group">
                                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownButton">
                                                    ALL
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-animated">
                                                    <a class="dropdown-item" onclick="updateState(2, 'PENDING')">For Good</a>
                                                    <a class="dropdown-item" onclick="updateState(3, 'ASSIGNED')">REPLACEMENT</a>
                                                </div>
                                            </div>
                                            <!-- Add more buttons for additional tables if needed -->
                                        </div></br>
                                        <table class="table table-centered mb-0 table-nowrap director_datatable " id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Requested By</th>
                                                    <th>Vehicle</th>
                                                    <th>Return</th>
                                                    <th>Requested At</th>
                                                    <th>Status</th>
                                                    <th>Inspection</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
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
                            <dd class="col-sm-7" id="show_Reason"></dd>
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

         <!-- show all the information about the request modal -->
        <div id="replace-modal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Replace Vehicle</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="replaceForm" action="{{ route('Replacement.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <div class="tab-pane" id="account-2">
                            <div class="row">
                                <div class="position-relative mb-3">
                                    <label class="form-label" for="validationTooltip02">Old vehicle</label>
                                    <span  class="form-control" id="vehicle_id" ></span>
                                    <input type="hidden" class="form-control" id="permanent_id" name="permanent_id"></input>
                                    <input type="hidden" class="form-control" id="giving_back_id" name="giving_back_id"></input>
                                </div>
                                
                                <div class="position-relative mb-3">
                                    <label class="form-label" for="validationTooltip02">Select New Vehicle</label>
                                    <select class="form-control" id="routeSelect" name="new_vehicle_id" required>
                                        <option value="">Select Replacement</option>
                                        @foreach ($vehicles as $vec)
                                            <option value="{{$vec->vehicle_id}}">{{$vec->plate_number}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Submit</button>

                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end show modal -->

         <!-- Accept Alert Modal -->
         <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationModalLabel"aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('vehicle_director_approve_request') }}">
                            @csrf
                            <input type="hidden" name="request_id" id="request_accept_id">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <i class="ri-alert-line h1 text-warning"></i>
                                    <h4 class="mt-2">Warning</h4>
                                    <h5 class="mt-3">
                                        Are you sure you want to accept this request?</br> This action
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
                    <form method="POST" action="{{ route('vehicle_director_reject_request') }}">
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

       
</script>
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<script>
    let customDataValue = 0;


    function updateState(value, buttonText) {
        document.getElementById('dropdownButton').innerText = buttonText;
        customDataValue = value; 
        table.ajax.reload();
    }


var table = $('.director_datatable').DataTable({
    processing: true,
    pageLength: 5,
    serverSide: true,
    ajax: {
            url: "{{ route('FetchReturnDirector') }}",
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
            data: 'vehicle',
            name: 'vehicle'
        },
        {
            data: 'reason',
            name: 'reason'
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
            data: 'inspect',
            name: 'inspect'
        },
        
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        },
    ]
});

    $(document).ready(function() {
        $(document).on('click', '.inspect-btn', function() {    
            var inspection = $(this).data('id');
            console.log(inspection);
            // var inspection = this.getAttribute('data-value');                                
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
    });

    $(document).ready(function() {
        var ShowReason;

        $(document).on('click', '.show-btn', function() {
            ShowReason = $(this).data('id');

            console.log(ShowReason);

            
            $('#show_Reason').text(ShowReason);
            $('#standard-modal').modal('toggle');
        });
    });

    $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.accept-btn', function() {
                AcceptedId = $(this).data('id');
console.log(AcceptedId);
                $('#request_accept_id').val(AcceptedId);
                $('#confirmationModal').modal('show');
            });
        });

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.replace-btn', function() {
                Vehicle = $(this).data('vehicle');
                Permanent = $(this).data('id');
                AcceptedId = $(this).data('request');
                Giving = $(this).data('request');
            console.log(Giving);
                $('#vehicle_id').text(Vehicle);
                $('#giving_back_id').val(Giving);
                $('#permanent_id').val(Permanent);
                $('#request_id').val(AcceptedId);
                $('#replace-modal').modal('show');
            });
        });

    $(document).ready(function() {
        var RejectedId;

        $(document).on('click', '.reject-btn', function() {
            RejectedId = $(this).data('id');

            $('#Reject_request_id').val(RejectedId);
            $('#staticBackdrop').modal('toggle');
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
