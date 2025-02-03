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

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Daily KM Registration</h4>
                            </div>
                            <div class="card-body">
                                <div id="progressbarwizard">
                                    <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                        <li class="nav-item">
                                            <a href="#account2" data-bs-toggle="tab" data-toggle="tab"
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

                                        <div class="tab-pane" id="account2">
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
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>

                    <div class="col-7">
                        <div class="card">
                            <div class="card-body">
                                <table id="basic-datatable" class="table table-striped table-responsive dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Vehicle</th>
                                            <th>Morning Km</th>
                                            <th>Night Difference</th>
                                            <th>Evening km</th>
                                            <th>Day Difference</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>                                  
                                    @foreach ($TodaysDate as $data)
                                        <tbody>
                                            <tr>
                                                <td>{{ $data->vehicle->plate_number }}</td>
                                                <td>{{ $data->morning_km }}</td>
                                                <td>{{ $data->getNightKmAttribute($data->vehicle_id) }}</td>
                                                <td>{{ $data->afternoon_km }}</td>
                                                <td>{{ $data->getDailyKmAttribute() }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#standardmodal-{{ $loop->index }}"
                                                        title="Show"><i class=" ri-edit-line"></i></button>
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
                                                        <form action="{{ route('daily_km.page.update') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="tab-pane" id="account2">
                                                                <div class="row">
                                                                <div class="position-relative mb-3">
                                                                        <div class="mb-6 position-relative"
                                                                            id="datepicker1">
                                                                            <label class="form-label">Morning Km</label>
                                                                            <input type="text" name="morning_km"
                                                                                class="form-control"
                                                                                value="{{ $data->morning_km }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="position-relative mb-3">
                                                                        <div class="mb-6 position-relative"
                                                                            id="datepicker1">
                                                                            <label class="form-label">Afternoon Km</label>
                                                                            <input type="text" name="afternoon_km"
                                                                                class="form-control"
                                                                                value="{{ $data->afternoon_km }}">

                                                                        </div>
                                                                        <input type="text" name="calc_id"
                                                                                class="form-control"
                                                                                value="{{ $data->calculation_id }}" hidden>
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
                                        <div id="DisplayDifference" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">KM Difference</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="tab-pane" id="account2">
                                                        <div class="row">
                                                            <div class="position-relative mb-3">
                                                            <label class="form-label">Morning Difference</label>
                                                            <input type="text" id="morningDifferenceInput" class="form-control" readonly>
                                                            </div>
                                                            <div class="position-relative mb-3">
                                                            <label class="form-label">Afternoon Difference</label>
                                                            <input type="text" id="dayDifferenceInput" class="form-control" readonly>
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
        document.addEventListener('DOMContentLoaded', function () {
    const selectTime = document.getElementById('time');
    const morning = document.getElementById('morning');
    const evening = document.getElementById('evening');
    const vehicleIdHidden = document.getElementById('vehicle_id_hidden');
    const vehicleIdHiddenAfternoon = document.getElementById('vehicle_id_hidden_afternoon');

    // Helper function to toggle visibility and disable inputs
    function toggleVisibility(sectionToShow, sectionToHide) {
        sectionToShow.style.display = 'block';
        sectionToHide.style.display = 'none';

        Array.from(sectionToShow.querySelectorAll('input, select')).forEach(input => input.disabled = false);
        Array.from(sectionToHide.querySelectorAll('input, select')).forEach(input => input.disabled = true);
    }

    // Handle time selection
    selectTime.addEventListener('change', function () {
        if (selectTime.value === 'morning') {
            toggleVisibility(morning, evening);
        } else if (selectTime.value === 'evening') {
            toggleVisibility(evening, morning);
        }
    });

    // Handle department change
    const departmentSelect = document.getElementById('department_id');
    if (departmentSelect) {
        departmentSelect.addEventListener('change', function () {
            const selectedId = this.value;

            vehicleIdHidden.value = selectedId;
            vehicleIdHiddenAfternoon.value = selectedId;

            // AJAX request
            $.ajax({
                url: @json(route('daily_km.page.check')),
                method: 'GET',
                data: { id: selectedId },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        if (response.message?.includes('Morning km is filled')) {
                            document.querySelector('select[name="Time"] option[value="morning"]').hidden = true;
                            morning.style.display = 'none';
                        } else {
                            document.querySelector('select[name="Time"] option[value="morning"]').hidden = false;
                        }

                        if (response.message?.includes('Afternoon km is filled')) {
                            document.querySelector('select[name="Time"] option[value="evening"]').hidden = true;
                            evening.style.display = 'none';
                        } else {
                            document.querySelector('select[name="Time"] option[value="evening"]').hidden = false;
                        }
                    }
                },
                error: function (err) {
                    console.error('An error occurred:', err);
                }
            });
        });
    }

    // Modal handling
    const displayDifferenceModal = document.getElementById('displayDifferenceModal');
    if (displayDifferenceModal) {
        displayDifferenceModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            const morningDifference = button.getAttribute('morning_difference') || '';
            const dayDifference = button.getAttribute('data-day_difference') || '';

            document.getElementById('morningDifferenceInput').value = morningDifference;
            document.getElementById('dayDifferenceInput').value = dayDifference;
        });
    }
});

        </script>
        
       <script src="{{ asset('assets/js/app.min.js') }}"></script>
       @endsection
       <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
