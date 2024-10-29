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
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Request Permanent Vehicle</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vec_perm_request_post') }}" method="post"
                                    enctype="multipart/form-data">
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

                                                    <div class="position-relative mb-3">
                                                        <label class="form-label">Upload Position Latter</label>
                                                        <input name="position_letter" class="form-control" type="file">
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

                    <div class="col-7">
                        <div class="card">
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Roll.no</th>
                                            <th>Date Requested</th>
                                            <th>status</th>
                                            <th>Vehicle</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    @foreach ($Requested as $request)
                                        <tbody>
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $request->created_at->format('M j, Y,') }}</td>
                                                <td>{{ $request->status == 1 ? 'Approved' : 'Pending' }}</td>
                                                <td>{{ $request->vehicle_id !== null ? $request->vehicle->plate_number : ' ' }}
                                                </td>
                                                <td>
                                                    {{-- <button type="button" class="btn btn-info rounded-pill" title="show"><i class=" ri-eye-line"></i></button> --}}
                                                    <form method="POST" action="{{ route('user_perm_delet') }}">
                                                        @csrf
                                                        <input type="hidden" name="request_id"
                                                            value="{{ $request->vehicle_request_permanent_id }}">
                                                        @if ($request->approved_by === null && $request->director_reject_reason === null)
                                                            <a href="{{ route('perm_vec_update') }}"
                                                                class="btn btn-secondary rounded-pill"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#standard-modal-{{ $loop->index }}"
                                                                title="edit"><i class=" ri-edit-line"></i></a>
                                                            <button type="submit" class="btn btn-danger rounded-pill"
                                                                title="Delete"><i class="ri-close-circle-line"></i></button>
                                                        @endif
                                                    </form>
                                                    @if ($request->vehicle_id !== null)
                                                        <input type="hidden" value="{{ $request->vehicle_id }}"
                                                            id="vehicleselection">
                                                        <a href="#" class="btn btn-info rounded-pill" id="assignBtn"
                                                            title="Inspect">Inspect</a>
                                                    @endif
                                                    @if ($request->vehicle_id !== null && $request->accepted_by_requestor == null)
                                                        <a href="{{ route('accept_assigned_vehicle', ['id' => $request->vehicle_request_permanent_id]) }}"
                                                            class="btn btn-primary rounded-pill" title="Accept">Accept</a>
                                                        <button type="button" class="btn btn-danger rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop-{{ $loop->index }}"
                                                            title="Reject">Reject</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                        <script>
                                            document.getElementById('assignBtn').addEventListener('click', function() {
                                                var selectedCarId = document.getElementById('vehicleselection').value;

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
                                                            var inspectedBy = response.data[0].inspected_by;
                                                            var createdAt = new Date(response.data[0].created_at).toLocaleDateString(
                                                                'en-US', {
                                                                    year: 'numeric',
                                                                    month: '2-digit',
                                                                    day: '2-digit'
                                                                });
                                                            // Create a section to display "Inspected By" and "Created At" at the top right corner
                                                            var infoSection = document.createElement('div');
                                                            infoSection.className =
                                                            'd-flex justify-content-end mb-3'; // Flexbox to align right and add margin-bottom
                                                            infoSection.innerHTML = `
                                                    <p><strong>Inspected By:</strong> ${inspectedBy} </br>
                                                    <strong>Created At:</strong> ${createdAt}</p>
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
                                        <!-- show all the information about the request modal -->
                                        <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
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
                                                                    <div class="position-relative mb-3">
                                                                        <div class="mb-6 position-relative"
                                                                            id="datepicker1">
                                                                            <label class="form-label">Reason</label>
                                                                            <input type="text" name="purpose"
                                                                                value="{{ $request->purpose }}"
                                                                                class="form-control"
                                                                                placeholder="Enter purpose of Request"
                                                                                required>
                                                                            <input type="hidden" name="request_id"
                                                                                value="{{ $request->vehicle_request_permanent_id }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="position-relative mb-3">
                                                                        <label class="form-label">Upload Position
                                                                            Latter</label>
                                                                        <input name="position_letter" class="form-control"
                                                                            type="file" required>
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

                                        <!-- this is for the Reject  modal -->
                                        <div class="modal fade" id="staticBackdrop-{{ $loop->index }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                                    <input type="hidden" name="request_id"
                                                                        value="{{ $request->vehicle_request_permanent_id }}">
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
                                    @endforeach
                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
            </div>
        </div>


        <!-- Dropzone File Upload js -->
        <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

        <!-- File Upload Demo js -->
        <script src="{{ asset('assets/js/pages/fileupload.init.js') }}"></script>
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>
    @endsection
