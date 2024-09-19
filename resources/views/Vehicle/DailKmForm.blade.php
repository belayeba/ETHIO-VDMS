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

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Add vehicle part for inspection</h4>
                            </div>
                            <div class="card-body">
                                <!-- <form action="" method="post" enctype="multipart/form-data">
                                                            @csrf -->

                                <div id="progressbarwizard">
                                    <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                        <li class="nav-item">
                                            <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 py-2">
                                                <i class="ri-settings-5-line fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">ADD</span>
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
                                                    <div class="mb-6 position-relative">
                                                        <label class="form-label">Select Vehicle</label>
                                                        <select class="form-control" id="department_id" name="vehicle_id">
                                                            <option value="" disabled selected>Select</option>
                                                            @foreach ($vehicle as $vec)
                                                                <option value="{{ $vec->vehicle_id }}">
                                                                    {{ $vec->plate_number }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative">
                                                        <label class="form-label">Select Time</label>
                                                        <select class="form-control" id="time" name="Time">
                                                            <option value="" disabled selected>Select</option>
                                                            <option value="morning">Morning</option>
                                                            <option value="evening">Evening</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <form action="{{ route('daily_km.page.morning') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="position-relative mb-3" id="morning" style="display:none">
                                                        <div class="mb-6 position-relative">
                                                            <label class="form-label">Morning KM</label>
                                                            <input type="text" name="morning_km" class="form-control"
                                                                placeholder="Enter Mornig KM">
                                                            <input type="hidden" id="vehicle_id_hidden" name="vehicle">
                                                        </div></br>
                                                        <ul class="list-inline wizard mb-0">
                                                            <li class="next list-inline-item float-end">
                                                                <button type="submit" class="btn btn-info">Submit
                                                                    Morning</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                                <form action="{{ route('daily_km.page.evening') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="position-relative mb-3" id="evening" style="display:none">
                                                        <div class="mb-6 position-relative">
                                                            <label class="form-label">Evening KM</label>
                                                            <input type="text" name="afternoon_km" class="form-control"
                                                                placeholder="Enter Evening KM">
                                                            <input type="hidden" id="vehicle_id_hidden_afternoon"
                                                                name="vehicle">
                                                        </div></br>
                                                        <ul class="list-inline wizard mb-0">
                                                            <li class="next list-inline-item float-end">
                                                                <button type="submit" class="btn btn-info">Submit
                                                                    Evening</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- <ul class="list-inline wizard mb-0">
                                                                            <li class="next list-inline-item float-end">
                                                                                <button type="submit" class="btn btn-info">Submit</button>
                                                                            </li>
                                                                        </ul> -->

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
                                            <th>Vehicle</th>
                                            <th>Morning Km</th>
                                            <th>Evening km</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach ($TodaysDate as $data)
                                        <tbody>
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->vehicle->plate_number }}</td>
                                                <td>{{ $data->morning_km }}</td>
                                                <td>{{ $data->afternoon_km }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#standardmodal-{{ $loop->index }}"
                                                        title="Show"><i class=" ri-eye-line"></i></button>
                                                    <button type="button" class="btn btn-danger rounded-pill"
                                                        data-bs-toggle="modal" data-bs-target="" title="Reject"><i
                                                            class=" ri-close-circle-fill"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <!-- edit the information of the request modal -->
                                        <div id="standardmodal-{{ $loop->index }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Daily Km update
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post"
                                                            enctype="multipart/form-data">

                                                            <div class="tab-pane" id="account-2">
                                                                <div class="row">
                                                                    <div class="position-relative mb-3">
                                                                        <div class="mb-6 position-relative"
                                                                            id="datepicker1">
                                                                            <label class="form-label">Vehicle</label>
                                                                            <input type="text" name="afternoon_km"
                                                                                class="form-control"
                                                                                value="{{ $data->vehicle->plate_number }}"
                                                                                readonly tabindex="-1"
                                                                                style="user-select: none; pointer-events: none;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="position-relative mb-3">
                                                                        <div class="mb-6 position-relative"
                                                                            id="datepicker1">
                                                                            <label class="form-label">Morning km</label>
                                                                            <input type="text" name="afternoon_km"
                                                                                class="form-control"
                                                                                value="{{ $data->morning_km }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="position-relative mb-3">
                                                                        <label class="form-label">Note</label>

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
                                    @endforeach

                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->

                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectTime = document.getElementById('time');
                const morning = document.getElementById('morning');
                const evening = document.getElementById('evening');
                const morningInput = document.querySelector('input[name="morning_km"]');
                const eveningInput = document.querySelector('input[name="evening_km"]');

                selectTime.addEventListener('change', function() {
                    if (selectTime.value === 'morning') {
                        morning.style.display = 'block';
                        evening.style.display = 'none';
                    } else if (selectTime.value === 'evening') {
                        morning.style.display = 'none';
                        evening.style.display = 'block';
                    } else {
                        morningInput.style.display = 'none';
                        eveningInput.style.display = 'none';
                    }
                });
            });

            document.getElementById('department_id').addEventListener('change', function() {
                let selectedId = this.value; // Retrieve the selected ID
                const morningInput = document.querySelector('input[name="morning_km"]');
                const eveningInput = document.querySelector('input[name="evening_km"]');

                document.getElementById('vehicle_id_hidden').value = selectedId;
                document.getElementById('vehicle_id_hidden_afternoon').value = selectedId;
                // Craft and send the Ajax request
                $.ajax({
                    url: '{{ route('daily_km.page.check') }}',
                    method: 'GET',
                    data: {
                        id: selectedId
                    },
                    success: function(response) {
                        // Process the retrieved data from the backend
                        console.log(response);
                        if (response.success && response.message.includes('Morning km is filled')) {
                            document.querySelector('select[name="Time"] option[value="morning"]').hidden =
                                true;
                            morning.style.display = 'none';
                        }

                        if (response.success && response.message.includes('Afternoon km is filled')) {
                            document.querySelector('select[name="Time"] option[value="evening"]').hidden =
                                true;
                            evening.style.display = 'none';
                        }
                        if (!response.message.includes('Morning km is filled') && !response.message
                            .includes('Afternoon km is filled')) {
                            document.querySelector('select[name="Time"] option[value="morning"]').hidden =
                                false;
                            document.querySelector('select[name="Time"] option[value="evening"]').hidden =
                                false;
                        }
                    },
                    error: function(err) {
                        console.error('An error occurred:', err);
                    }
                });
            });
        </script>
        <!-- Dropzone File Upload js -->
        <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

        <!-- File Upload Demo js -->
        <script src="{{ asset('assets/js/pages/fileupload.init.js') }}"></script>
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>
    @endsection
