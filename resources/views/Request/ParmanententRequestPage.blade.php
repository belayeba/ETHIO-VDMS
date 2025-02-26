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
                                <form action="{{ route('vec_perm_request_post') }}" id="permanent_request_form" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div id="progressbarwizard">
                                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                            <li class="nav-item">
                                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">@lang('messages.Request')</span>
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
                                                            <label class="form-label">@lang('messages.Reason')</label>
                                                            <input type="text" name="purpose" class="form-control"
                                                                placeholder="Enter purpose of Request">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nameInput" class="form-label">@lang('messages.position') <strong class="text-danger">*</strong></label>
                                                        <input type="text" class="form-control" id="position" name="position" placeholder="Enter Your Position">
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <label class="form-label">@lang('messages.Upload Position Letter')</label>
                                                        <input name="position_letter" class="form-control" type="file">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nameInput" class="form-label">@lang('messages.License Number')<strong class="text-danger">*</strong></label>
                                                        <input type="text" class="form-control" id="license_number" name="license_number" placeholder="Enter License Number">
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">@lang('messages.License expiry date')</label>
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
                                                        <label class="form-label">@lang('messages.Upload Driving License')</label>
                                                        <input name="Driving_license" class="form-control" type="file">
                                                    </div>
                                                </div>

                                                <ul class="list-inline wizard mb-0">
                                                    <li class="next list-inline-item float-end">
                                                        <button type="submit" class="btn btn-info">@lang('messages.Submit')</button>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('permanent_request_form').addEventListener('submit', function() {
                                            let button = document.getElementById('permanent_request_form_submit');
                                            button.disabled = true;
                                            button.innerText = "Processing..."; 
                                        });
                                    </script>

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
                                                <th>{{ __('messages.Roll No.') }}</th>
                                                <th>{{ __('messages.Requested Date') }}</th>
                                                <th>{{ __('messages.Status') }}</th>
                                                <th>{{ __('messages.Vehicle') }}</th>
                                                <th>{{ __('messages.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- show all the information about the request modal -->
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
                                                        <dt class="col-sm-5">@lang('messages.position')</dt>
                                                        <dd class="col-sm-7" id="ShowPosition"></dd>
                                                    </dl>

                                                    <dl class="row mb-1">
                                                        <dt class="col-sm-5">@lang('messages.Request reason'):</dt>
                                                        <dd class="col-sm-7" id="reason"></dd>
                                                    </dl>
                                                </div></br></br>
                                                <div class="row">
                                                    <!-- Left Card -->
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title">@lang('messages.Position Letter')</h5>
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
                                                                <h5 class="card-title">@lang('messages.Driving License')</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <iframe id="image2" src="" alt="Driving License" class="img-fluid"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('messages.Close')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end show modal -->

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
                                                        <i class="ri-alert-line h1 text-danger"></i>
                                                        <h4 class="mt-2">@lang('messages.Warning')</h4>
                                                        <h5 class="mt-3">
                                                            @lang('messages.Are you sure you want to accept this request?')</br> @lang('messages.This action cannot be undone.')
                                                        </h5>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">@lang('messages.Cancel')</button>
                                                        <button type="submit" class="btn btn-danger"
                                                            id="confirmDelete">@lang('messages.Yes, Accept')</button>
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
                                                            <input type="hidden" name="request_id" id="rejected_id">
                                                            <textarea class="form-control" name="reason" style="height: 60px;" required></textarea>
                                                            <label for="floatingTextarea">@lang('messages.Reason')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                    <button type="submit" class="btn btn-danger">@lang('messages.Reject')</button>
                                                </div> <!-- end modal footer -->
                                            </form>
                                        </div> <!-- end modal content-->
                                    </div> <!-- end modal dialog-->
                                </div>
                                <!-- end assign modal -->

                                <!-- show all the information about the request modal -->
                                <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="edit-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="edit-modalLabel">Request Update
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
                                                                <label for="nameInput" class="form-label">@lang('messages.position') <strong class="text-danger">*</strong></label>
                                                                <input type="text" class="form-control" id="editposition" name="position" placeholder="Enter Your Position">
                                                            </div>
                                                            <div class="position-relative mb-3">
                                                                <div class="mb-6 position-relative" id="datepicker1">
                                                                    <label class="form-label">@lang('messages.Reason')</label>
                                                                    <input type="text" name="purpose"
                                                                        id="editrequest_reason" class="form-control" required>
                                                                    <input type="hidden" name="request_id"
                                                                        id="request_id">
                                                                </div>
                                                            </div>

                                                            <div class="position-relative mb-3">
                                                                <label class="form-label">@lang('messages.Upload Position Letter')</label>
                                                                <input name="position_letter" class="form-control"
                                                                    type="file" required>
                                                            </div>
                                                            <div class="mb-3">
                                                        <label for="nameInput" class="form-label">@lang('messages.License Number')<strong class="text-danger">*</strong></label>
                                                        <input type="text" class="form-control" id="editlicense_number" name="license_number" placeholder="Enter License Number">
                                                    </div>
                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">@lang('messages.License expiry date')</label>
                                                            <input type="text" class="form-control" name="expiry_date"
                                                                placeholder="Enter license expiry date" id="editexpirydate">
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
                                                                <label class="form-label">@lang('messages.Upload Driving License')</label>
                                                                <input name="Driving_license" class="form-control"
                                                                    type="file" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                <button type="submit" class="btn btn-info">@lang('messages.Submit')</button>
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
                                                <h4 class="modal-title" id="standard-modalLabel">@lang('messages.Inspection Details')</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row mt-3" id="inspectionCardsContainer"
                                                    class="table table-striped">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">@lang('messages.Close')</button>
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
                    $(document).on('click', '.edit-btn', function() {
                        var requestReason = $(this).data('reason');
                        var requestId =$(this).data('id');
                        var Position = $(this).data('position');
                        var license = $(this).data('license');
                        var expiry = $(this).data('expire')
                        // Populate modal fields
                        
                       $('#editrequest_reason').val(requestReason);
                       $('#editposition').val(Position);
                       $('#editlicense_number').val(license);
                       $('#editexpirydate').val(expiry);
                       $('#editrequest_id').val(requestId);
                       $('#edit-modal').modal('show');
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
                                        if(inspection.type == "normal_part")
                                         {
                                            var row = document.createElement('tr');
                                            row.innerHTML = `
                                            <td>${inspection.part_name}</td>
                                            <td>${inspection.is_damaged ? 'No' : 'Yes'}</td>
                                            <td>${inspection.damage_description ? inspection.damage_description : '-'}</td>
                                            `;
                                            table.querySelector('tbody').appendChild(
                                                row); // Append row to the table body
                                        }
                                });
                                cardsContainer.appendChild(h1);
                                cardsContainer.appendChild(table);
                                // Spare Part
                                var table = document.createElement('table');
                                table.className = 'table table-striped'; // Add Bootstrap classes for styling
                                table.innerHTML = `
                                        <thead>
                                            <tr>
                                                <th>Spare Part</th>
                                                <th>Is Available</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    `;

                                response.data.forEach(function(inspection) 
                                {
                                    if(inspection.type == "spare_part")
                                        {
                                            var row = document.createElement('tr');
                                            row.innerHTML = `
                                            <td>${inspection.part_name}</td>
                                            <td>${inspection.is_damaged == "0"? 'No' : 'Yes'}</td>
                                            <td>${inspection.damage_description ? inspection.damage_description : '-'}</td>
                                            `;
                                                table.querySelector('tbody').appendChild(
                                                    row); // Append row to the table body
                                        }
                                });
                                cardsContainer.appendChild(h2);
                                cardsContainer.appendChild(table);

                            } 
                            else 
                            {
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

                $(document).ready(function() {
                    var RejectedId;

                    $(document).on('click', '.show-btn', function() {
                        RejectedId = $(this).data('id');
                        Reason = $(this).data('reason');
                        Position = $(this).data('position');
                        PositionLetter = $(this).data('position_letter');
                        DrivingLicense = $(this).data('driving_license');

                        console.log(Position);

                        // Construct file paths for the iframes
                        const positionLetterPath = '/storage/PermanentVehicle/PositionLetter/' + PositionLetter;
                        const drivingLicensePath = '/storage/PermanentVehicle/Driving_license/' + DrivingLicense;

                        // Populate the iframes with the file paths
                        $('#reason').text(Reason);
                        $('#ShowPosition').text(Position);
                        $('#image1').attr('src', positionLetterPath);
                        $('#image2').attr('src', drivingLicensePath);
                        $('#Reject_request_id').val(RejectedId);
                        $('#standard-modal').modal('toggle');
                    });
                });
            </script>

            <!-- Dropzone File Upload js -->
            <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

            <script src="assets/js/vendor.min.js"></script>
            <script src="assets/js/app.min.js"></script>
        @endsection
