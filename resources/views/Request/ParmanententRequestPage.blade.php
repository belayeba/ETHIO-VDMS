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

            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Error - </strong> {!! session('error_message') !!}
                </div>
            @endif

            @if (Session::has('success_message'))
                <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong> Success- </strong> {!! session('success_message') !!}
                </div>
            @endif

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Form Section -->
                    <div class="col-12 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Request Permanent Vehicle</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vec_perm_request_post') }}" method="post" enctype="multipart/form-data">
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
                                                                placeholder="Enter purpose of Request">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nameInput" class="form-label">Position <strong class="text-danger">*</strong></label>
                                                        <input type="text" class="form-control" id="position" name="position" placeholder="Enter Your Position">
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <label class="form-label">Upload Position Latter</label>
                                                        <input name="position_letter" class="form-control" type="file">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nameInput" class="form-label">License Number <strong class="text-danger">*</strong></label>
                                                        <input type="text" class="form-control" id="license_number" name="license_number" placeholder="Enter License Number">
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">License expiry date </label>
                                                            <input type="text" class="form-control" name="expiry_date"
                                                                placeholder="Enter license expiry date" id="expirydate">
                                                        </div>
                                                        <script>
                                                            $('#expirydate').calendarsPicker({
                                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                                pickerClass: 'myPicker',
                                                                dateFormat: 'yyyy-mm-dd'
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <label class="form-label">Upload Driving License</label>
                                                        <input name="Driving_license" class="form-control" type="file">
                                                    </div>
                                                </div>

                                                <ul class="list-inline wizard mb-0">
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

                    <div class="col-12 col-lg-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table Permanent_datatable table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Roll.no</th>
                                                <th>Date Requested</th>
                                                <th>status</th>
                                                <th>Vehicle</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Warning Alert Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('user_perm_delet') }}">
                                                @csrf
                                                <input type="hidden" name="request_id" id="request_id">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i class="ri-alert-line h1 text-warning"></i>
                                                        <h4 class="mt-2">Warning</h4>
                                                        <h5 class="mt-3">
                                                            Are you sure you want to delete this item? This action cannot be
                                                            undone.
                                                        </h5>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger"
                                                            id="confirmDelete">Yes,
                                                            Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <!-- this is for the Reject  modal -->
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
                                            <form method="POST" action="{{ route('reject_assigned_vehicle') }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-lg-6">
                                                        <h5 class="mb-3"></h5>
                                                        <div class="form-floating">
                                                            <input type="text" name="request_id" id="rejected_id">
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

                                <!-- show all the information about the request modal -->
                                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Request Update
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('perm_vec_update') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf


                                                    <div class="tab-pane" id="account-2">
                                                        <div class="row">
                                                            <div class="mb-3">
                                                                <label for="nameInput" class="form-label">Position <strong class="text-danger">*</strong></label>
                                                                <input type="text" class="form-control" id="position" name="position" placeholder="Enter Your Position">
                                                            </div>
                                                            <div class="position-relative mb-3">
                                                                <div class="mb-6 position-relative" id="datepicker1">
                                                                    <label class="form-label">Reason</label>
                                                                    <input type="text" name="purpose"
                                                                        id="request_reason" class="form-control" required>
                                                                    <input type="hidden" name="request_id"
                                                                        id="request_id">
                                                                </div>
                                                            </div>

                                                            <div class="position-relative mb-3">
                                                                <label class="form-label">Upload Position
                                                                    Latter</label>
                                                                <input name="position_letter" class="form-control"
                                                                    type="file" required>
                                                            </div>
                                                            <div class="mb-3">
                                                        <label for="nameInput" class="form-label">License Number <strong class="text-danger">*</strong></label>
                                                        <input type="text" class="form-control" id="license_number" name="license_number" placeholder="Enter License Number">
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">License expiry date </label>
                                                            <input type="text" class="form-control" name="expiry_date"
                                                                placeholder="Enter license expiry date" id="expirydate">
                                                        </div>
                                                        <script>
                                                            $('#expirydate').calendarsPicker({
                                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                                pickerClass: 'myPicker',
                                                                dateFormat: 'yyyy-mm-dd'
                                                            });
                                                        </script>
                                                    </div>
                                                            <div class="position-relative mb-3">
                                                                <label class="form-label">Upload Driving
                                                                    License</label>
                                                                <input name="Driving_license" class="form-control"
                                                                    type="file" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- end show modal -->
                                <!-- show inspection modal -->
                                <div id="showinspection-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Inspection
                                                    Details</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row mt-3" id="inspectionCardsContainer"
                                                    class="table table-striped">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                    <!-- end show modal -->
                                    {{-- @endforeach --}}
                                </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                </div>
            </div>

            <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

            <script>
                var table = $('.Permanent_datatable').DataTable({
                    processing: true,
                    pageLength: 5,
                    serverSide: true,
                    ajax: "{{ route('FetchPermanentRequest') }}",
                    columns: [{
                            data: 'counter',
                            name: 'counter'
                        },
                        {
                            data: 'start_date',
                            name: 'start_date'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'vehicle',
                            name: 'vehicle'
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
                    $('#standard-modal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget);
                        var modal = $(this);

                        var requestReason = button.data('reason');
                        var requestId = button.data('id');

                        // Populate modal fields
                        modal.find('#request_reason').val(requestReason);
                        modal.find('#request_id').val(requestId);
                    });
                });

                $(document).ready(function() {
                    var deleteId;

                    $(document).on('click', '.delete-btn', function() {
                        deleteId = $(this).data('id');

                        $('#request_id').val(deleteId);
                        $('#confirmationModal').modal('show');
                    });
                });

                $(document).ready(function() {
                    var RjectedId;

                    $(document).on('click', '.reject-btn', function() {
                        RjectedId = $(this).data('id');

                        $('#rejected_id').val(RjectedId);
                        $('#staticBackdrop').modal('show');
                    });
                });
            </script>

            <script>
                $(document).on('click', '.assignBtn', function(event) {
                    event.preventDefault();

                    // Get the vehicle ID from the data-id attribute
                    var selectedCarId = $(this).data('id');
                    console.log(selectedCarId);
                    // Perform an Ajax request to fetch data based on the selected car ID
                    $.ajax({
                        url: "{{ route('inspection.ByVehicle') }}",
                        type: 'GET',
                        data: {
                            id: selectedCarId
                        },
                        success: function(response) {
                            $('#showinspection-modal').modal('show');
                            var cardsContainer = document.getElementById('inspectionCardsContainer');
                            cardsContainer.innerHTML = ''; // Clear previous cards

                            if (response.status === 'success' && Array.isArray(response.data) && response.data
                                .length > 0) {
                                // Create the table
                                var Image = response.data[0].image_path;
                                var imageUrl = Image ? "{{ asset('storage/vehicles/Inspections/') }}" + '/' + Image : null;
                                var inspectedBy = response.data[0].inspected_by;
                                var createdAt = new Date(response.data[0].created_at).toLocaleDateString(
                                    'en-US', {
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
                                cardsContainer.appendChild(
                                    infoSection); // Append the info section before the table

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
                                    table.querySelector('tbody').appendChild(
                                        row); // Append row to the table body
                                });

                                cardsContainer.appendChild(table);

                            } else {
                                // Handle the case where no data is available
                                cardsContainer.innerHTML = '<p>No inspection data available.</p>';
                            }
                        },
                        error: function() {
                            $('#showinspection-modal').modal('show');
                            var cardsContainer = document.getElementById('inspectionCardsContainer');
                            cardsContainer.innerHTML = ''; // Clear previous cards
                            cardsContainer.innerHTML =
                                '<p>No inspection data available at the moment. Please check the Plate number!</p>';
                        }
                    });
                });
            </script>

            <!-- Dropzone File Upload js -->
            <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

            <script src="assets/js/vendor.min.js"></script>
            <script src="assets/js/app.min.js"></script>
        @endsection
