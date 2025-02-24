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
                            <h4 class="header-title">@lang('messages.Request Vehicle Service')</h4>
                        </div>
                        <div class="card-body">
                            <!-- Form content -->

                            <form method="POST" action="{{ route('temp_request_post') }}">
                                @csrf
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link rounded-0 py-2" id="displayprogresive">
                                            <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">@lang('messages.Request')</span>
                                        </a>
                                    </li>
                                </ul>

                                <div id="progressbarwizard" style="display: none">
                                    <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                        <li class="nav-item">
                                            <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 py-2">
                                                <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">@lang('messages.Reason')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 py-2">
                                                <i class="ri-timer-fill fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">@lang('messages.Duration')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 py-2">
                                                <i class=" ri-map-pin-fill fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">@lang('messages.Location')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#finish-3" data-bs-toggle="tab" data-toggle="tab"
                                                class="nav-link rounded-0 py-2">
                                                <i class=" ri-information-fill fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">@lang('messages.Info')</span>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item">
                                                <a href="#finish-4" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                    <i class=" ri-suitcase-3-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Extras</span>
                                                </a>
                                            </li> -->
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
                                                        <textarea type="text" name="purpose" class="form-control"
                                                            placeholder="Enter purpose of Request"></textarea>
                                                    </div>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                        <label class="form-label">@lang('messages.Vehicle Type')</label>
                                                        <select id="vehicle_type" name="vehicle_type" class="form-select" required>
                                                            <option value="">Select</option>
                                                            <option value="Human">Human</option>
                                                            <option value="Load">Load</option>
                                                            <option value="Load">Both</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list-inline wizard mb-0">
                                                <li class="next list-inline-item float-end">
                                                    <a href="javascript:void(0);" class="btn btn-info">@lang('messages.Next') <i
                                                            class="ri-arrow-right-line ms-1"></i></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-pane" id="profile-tab-2">
                                            <div class="row">
                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                        <label class="form-label">@lang('messages.Start Date')</label>
                                                        <input type="text" class="form-control" name="start_date"
                                                            placeholder="Enter Date of departure" id="startdate">
                                                    </div>
                                                    <script>
                                                        $('#startdate').calendarsPicker({
                                                            calendar: $.calendars.instance('ethiopian', 'am'),
                                                            pickerClass: 'myPicker',
                                                            dateFormat: 'yyyy-mm-dd'
                                                        });
                                                    </script>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                        <label class="form-label">@lang('messages.Start Time')</label>
                                                        <input type="time" class="form-control" name="start_time"
                                                            placeholder="Enter Time of departure">
                                                    </div>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                        <label class="form-label">@lang('messages.Return Date')</label>
                                                        <input type="text" class="form-control" name="return_date"
                                                            placeholder="Enter Date of arrival" id="enddate">
                                                    </div>
                                                    <script>
                                                        $('#enddate').calendarsPicker({
                                                            calendar: $.calendars.instance('ethiopian', 'am'),
                                                            pickerClass: 'myPicker',
                                                            dateFormat: 'yyyy-mm-dd'
                                                        });
                                                    </script>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                        <label class="form-label">@lang('messages.End Time')</label>
                                                        <input type="time" class="form-control" name="return_time"
                                                            placeholder="Enter Time of arrival">
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="pager wizard mb-0 list-inline">
                                                <li class="previous list-inline-item">
                                                    <button type="button" class="btn btn-light"><i
                                                            class="ri-arrow-left-line me-1"></i> @lang('messages.Back')</button>
                                                </li>
                                                <li class="next list-inline-item float-end">
                                                    <button type="button" class="btn btn-info">@lang('messages.Next') <i
                                                            class="ri-arrow-right-line ms-1"></i></button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-pane" id="finish-2">
                                            <div class="row">
                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                        <label class="form-label">@lang('messages.Location From')</label>
                                                        <input type="text" class="form-control"
                                                            name="start_location"
                                                            placeholder="Enter starting location">
                                                    </div>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                        <label class="form-label">@lang('messages.Location To')</label>
                                                        <input type="text" class="form-control"
                                                            name="end_location" placeholder="Enter arrival location">
                                                    </div>
                                                </div>
                                                <!-- <div class="position-relative mb-3"> -->
                                                <!-- <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Total KM</label>
                                                            <input type="number" class="form-control"
                                                                name="allowed_km" placeholder="Enter Total KM ">
                                                        </div> -->
                                                <!-- </div> -->
                                            </div> <!-- end card-body-->
                                            <ul class="pager wizard mb-0 list-inline mt-1">
                                                <li class="previous list-inline-item">
                                                    <button type="button" class="btn btn-light"><i
                                                            class="ri-arrow-left-line me-1"></i> @lang('messages.Back')</button>
                                                </li>
                                                <li class="next list-inline-item float-end">
                                                    <a href="#finish-3" type="button" class="btn btn-info">@lang('messages.Next') <i class="ri-arrow-right-line ms-1"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" id="finish-3">
                                            <div class="row">
                                                <!-- <h6 class="fs-15 mt-3">Do you have Driver?</h6>
                                                    <div class="mt-2">
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="with_driver" value="1">
                                                            <label class="form-check-label">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="with_driver" value="0">
                                                            <label class="form-check-label">No</label>
                                                        </div>
                                                    </div>
                                                    <div id="ToggleWithDriver" style="display:none">
                                                        <div class="row">

                                                            <p class="mb-1 fw-bold text-muted">Select Driver</p>
                                                            <select id="multiSelect1" name="driver_id"
                                                                class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple"
                                                                data-placeholder="Select People ...">
                                                                <optgroup label="Drivers">
                                                                    @foreach ($driver as $driver)
                                                                        <option value="{{ $driver->driver_id }}">
                                                                            <p style="color:black">{{ $driver->user->first_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                            {{-- <div id="selectedValues" class="mt-2"></div> --}}
                                                        </div>
                                                    </div> -->
                                                <h6 class="fs-15 mt-3">@lang('messages.In/Out Town')</h6>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="in_out_town" value="1">
                                                        <label class="form-check-label">@lang('messages.In Town')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="in_out_town" value="0">
                                                        <label class="form-check-label">@lang('messages.Out Town')</label>
                                                    </div>
                                                </div>
                                                <h6 class="fs-15 mt-3">@lang('messages.Is there a passenger or package?')</h6>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="package" value="1">
                                                        <label class="form-check-label">@lang('messages.Yes')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="package" value="0">
                                                        <label class="form-check-label">@lang('messages.No')</label>
                                                    </div>
                                                </div></br></br>
                                                <div id="TogglePackage" style="display:none"></br>
                                                    <div class="row"></br>
                                                        <p class="mb-1 fw-bold text-muted">@lang('messages.Search Passenger')</p>
                                                        <input type="text" id="searchBox" class="form-control mb-2" placeholder="Search for people..." />
                                                        <ul id="userSuggestions" class="list-group" style="max-height: 100px; overflow-y: auto;"></ul> <!-- Suggestions -->
                                                        <div id="selectedValues" class="mt-2"></div> <!-- Display selected users -->
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3 position-relative" id="datepicker1">
                                                                <label for="itemName" class="form-label">Item
                                                                    Name:</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Add Item" id="itemName">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="mb-3 position-relative" id="datepicker2">
                                                                <label for="itemWeight" class="form-label">@lang('messages.Weight(kg):')</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Add weight" id="itemWeight"
                                                                    step="0.01" min="0">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                                                            <button type="button"
                                                                class="btn btn-primary rounded-pill"
                                                                id="addItem">@lang('messages.Add')</button>
                                                        </div>
                                                    </div>

                                                    <div id="itemList"></div>
                                                </div>
                                            </div>
                                            <ul class="pager wizard mb-0 list-inline mt-1">
                                                <li class="previous list-inline-item">
                                                    <button type="button" class="btn btn-light"><i
                                                            class="ri-arrow-left-line me-1"></i> @lang('messages.Back')</button>
                                                </li>
                                                <li class="next list-inline-item float-end">
                                                    <button type="submit" class="btn btn-info">@lang('messages.Submit')</button>
                                                </li>
                                            </ul>
                                        </div>

                                        <script>
                                            //  window.onload = function() {
                                            //         location.reload();
                                            //     };
                                            const checkboxes = document.querySelectorAll(
                                                'input[name="with_driver"], input[name="in_out_town"], input[name="package"]');
                                            const packageCheckbox = document.querySelector('input[name="package"]');
                                            const withdriverCheckbox = document.querySelector('input[name="with_driver"]');
                                            const divToToggle = document.getElementById('TogglePackage');
                                            const withDriverToggle = document.getElementById('ToggleWithDriver');

                                            checkboxes.forEach((checkbox) => {
                                                checkbox.addEventListener('change', function() {
                                                    checkboxes.forEach((cb) => {
                                                        if (cb !== this && cb.name === this.name) {
                                                            cb.checked = false;
                                                            divToToggle.style.display = 'none';
                                                            withDriverToggle.style.display = 'none';
                                                        }
                                                    });
                                                });
                                            });

                                            packageCheckbox.addEventListener('change', function() {
                                                if (divToToggle) {
                                                    if (packageCheckbox.value == '1') {
                                                        divToToggle.style.display = 'block'; // Display the div if the checkbox value is 1
                                                    } else {
                                                        divToToggle.style.display = 'none';
                                                    }
                                                }
                                            });
                                            withdriverCheckbox.addEventListener('change', function() {
                                                if (withDriverToggle) {
                                                    if (withdriverCheckbox.value === 1) {
                                                        withDriverToggle.style.display = 'none'; // Display the div if the checkbox value is 1
                                                    } else {
                                                        withDriverToggle.style.display = 'block';
                                                    }
                                                }
                                            });
                                        </script>
                                    </div></br> <!-- end card-body-->
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="col-12 col-lg-7">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatable" class="Temporary_datatable table table-centered mb-0 table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.Roll No.') }}</th>
                                            <th>{{ __('messages.Requested Date') }}</th>
                                            <th>{{ __('messages.Status') }}</th>
                                            <th>{{ __('messages.Location') }}</th>
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
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Request Details</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="RequestContent">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-5">@lang('messages.Request reason')</dt>
                                                <dd class="col-sm-7" data-field="purpose"></dd>

                                                <dt class="col-sm-5">@lang('messages.Requested vehicle')</dt>
                                                <dd class="col-sm-7" data-field="vehicle_type"></dd>

                                                <dt class="col-sm-5">@lang('messages.Start date and Time')</dt>

                                                <dd class="col-sm-7" data-field="start_date"></dd>

                                                <dt class="col-sm-5">@lang('messages.Return date and Time')</dt>

                                                <dd class="col-sm-7" data-field="end_date"></dd>

                                                <dt class="col-sm-5">Location From and To</dt>

                                                <dd class="col-sm-7" data-field="start_location"></dd>

                                                <dt class="col-sm-5">@lang('messages.Passengers')</dt>

                                                <dd class="col-sm-7" data-field="passengers"></dd>

                                                <dt class="col-sm-5">Materials</dt>
                                                <dd class="col-sm-7" data-field="materials"></dd>

                                                <dt class="col-sm-5">Progress</dt>

                                                <dd class="col-sm-7" data-field="progress"></dd>
                                            </dl>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="printModal()">@lang('messages.Print')</button>
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">@lang('messages.Close')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end show modal -->
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>

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
                        <div class="modal-body">
                            <div class="col-lg-6">
                                <h5 class="mb-3"></h5>
                                <div class="form-floating">
                                    <input type="hidden" name="request_id" id="rejected_id">
                                    <textarea class="form-control" name="reason" id="reason" style="height: 100%;width: 100%;" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                        </div> <!-- end modal footer -->
                    </div> <!-- end modal content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end assign modal -->


            <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

            <script>
                var table = $('.Temporary_datatable').DataTable({
                    processing: true,
                    pageLength: 5,
                    serverSide: true,
                    ajax: "{{ route('FetchTemporaryRequest') }}",
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
                            data: 'location',
                            name: 'location'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                function printModal() {
                    var Content = document.getElementById("RequestContent").innerHTML;

                    var printWindow = window.open("", "", "width=800,height=600");
                    printWindow.document.write('<html><head><title>Request Details</title>');
                    printWindow.document.write('<style>body { font-family: Arial, sans-serif; } dt { font-weight: bold; }</style>');
                    printWindow.document.write('</head><body>');
                    printWindow.document.write(Content);
                    printWindow.document.write('</body></html>');

                    printWindow.document.close();
                    printWindow.print();
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const searchBox = document.getElementById('searchBox');
                    const userSuggestions = document.getElementById('userSuggestions');
                    const selectedValuesDiv = document.getElementById('selectedValues');

                    // Array to hold selected users
                    let selectedUsers = [];

                    // Handle search input
                    searchBox.addEventListener('input', function() {
                        const query = searchBox.value.trim();

                        // Send AJAX request to search users
                        if (query.length > 0) {
                            fetch(`/search-users?q=${encodeURIComponent(query)}`)
                                .then(response => response.json())
                                .then(data => {
                                    // Clear previous suggestions
                                    userSuggestions.innerHTML = '';

                                    // Populate suggestions with fetched data
                                    data.forEach(user => {
                                        const listItem = document.createElement('li');
                                        listItem.classList.add('list-group-item');
                                        listItem.textContent = user.first_name;
                                        listItem.setAttribute('data-id', user.id); // Store user ID in data attribute

                                        // Add click event to select a user
                                        listItem.addEventListener('click', function() {
                                            addUserToSelection(user);
                                        });

                                        userSuggestions.appendChild(listItem);
                                    });
                                })
                                .catch(error => console.error('Error fetching users:', error));
                        } else {
                            // If query is empty, clear the suggestions
                            userSuggestions.innerHTML = '';
                        }
                    });

                    // Function to add user to selection
                    function addUserToSelection(user) {
                        // Check if the user is already selected
                        if (!selectedUsers.some(u => u.id === user.id)) {
                            // Add user to the selected array
                            selectedUsers.push(user);
                            renderSelectedUsers();
                        }

                        // Clear the input field and suggestions
                        searchBox.value = '';
                        userSuggestions.innerHTML = '';
                    }

                    // Render the selected users as badges
                    function renderSelectedUsers() {
                        selectedValuesDiv.innerHTML = ''; // Clear previous badges

                        selectedUsers.forEach(user => {
                            const tag = document.createElement('span');
                            tag.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
                            tag.innerHTML = `
                            ${user.first_name}
                            <span class="remove-tag" data-id="${user.id}" style="cursor: pointer;">&times;</span>
                            <input type="hidden" name="people_id[]" value="${user.id}" />
                        `;
                            selectedValuesDiv.appendChild(tag);
                        });
                    }

                    // Handle badge removal
                    selectedValuesDiv.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-tag')) {
                            const userId = e.target.getAttribute('data-id');

                            // Remove user from the selected array
                            selectedUsers = selectedUsers.filter(user => user.id !== userId);

                            // Re-render the badges
                            renderSelectedUsers();
                        }
                    });
                });



                document.addEventListener('DOMContentLoaded', function() {
                    const select = document.getElementById('multiSelect');
                    const selectedValuesDiv = document.getElementById('selectedValues');

                    select.addEventListener('change', function() {
                        selectedValuesDiv.innerHTML = '';
                        Array.from(select.selectedOptions).forEach(option => {
                            const tag = document.createElement('span');
                            tag.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
                            tag.innerHTML = `${option.text} <span class="remove-tag" data-value="${option.value}">&times;</span>`;
                            selectedValuesDiv.appendChild(tag);
                        });
                    });

                    selectedValuesDiv.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-tag')) {
                            const value = e.target.getAttribute('data-value');
                            const option = select.querySelector(`option[value="${value}"]`);
                            option.selected = false;
                            e.target.parentElement.remove();
                        }
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {

                    const itemName = document.getElementById('itemName');
                    const itemWeight = document.getElementById('itemWeight');
                    const addButton = document.getElementById('addItem');
                    const itemList = document.getElementById('itemList');

                    const itemNames = [];
                    const itemWeights = [];

                    addButton.addEventListener('click', function() {
                        if (itemName.value && itemWeight.value) {
                            const itemDiv = document.createElement('div');
                            itemDiv.innerHTML = `
                        <span>${itemName.value} - ${itemWeight.value} kg</span>
                        <button class="removeItem">X</button>
                    `;
                            const nameInput = document.createElement('input');
                            nameInput.type = 'hidden';
                            nameInput.name = 'material_name[]';
                            nameInput.value = itemName.value;

                            const weightInput = document.createElement('input');
                            weightInput.type = 'hidden';
                            weightInput.name = 'weight[]';
                            weightInput.value = itemWeight.value;

                            itemDiv.appendChild(nameInput);
                            itemDiv.appendChild(weightInput);
                            itemList.appendChild(itemDiv);

                            itemName.value = '';
                            itemWeight.value = '';
                        }
                    });

                    itemList.addEventListener('click', function(e) {
                        if (e.target.classList.contains('removeItem')) {
                            const itemDiv = e.target.parentElement;

                            // Remove item from DOM
                            itemDiv.remove();
                        }
                    });
                });

                $('#standard-modal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var modal = $(this); // The modal

                    // Populate basic request details
                    modal.find('.modal-title').text('Request Details');
                    modal.find('[data-field="purpose"]').text(button.data('purpose'));
                    modal.find('[data-field="vehicle_type"]').text(button.data('vehicle_type'));
                    modal.find('[data-field="start_date"]').text(button.data('start_date') + ', ' + button.data(
                        'start_time'));
                    modal.find('[data-field="end_date"]').text(button.data('end_date') + ', ' + button.data('end_time'));
                    modal.find('[data-field="start_location"]').text(button.data('start_location'));
                    modal.find('[data-field="end_locations"]').text(button.data('end_locations'));

                    // Populate passengers
                    var passengers = button.data('passengers');
                    var passengerList = '';
                    if (passengers) {
                        passengers.forEach(function(person) {
                            passengerList += person.user.first_name + ' ' + person.user.middle_name + '<br>';
                        });
                    }
                    modal.find('[data-field="passengers"]').html(passengerList);

                    // Populate materials
                    var materials = button.data('materials');
                    var materialList = '';
                    if (materials) {
                        materials.forEach(function(material) {
                            materialList += material.material_name + ' ' + material.weight + '.<br>';
                        });
                    }
                    modal.find('[data-field="materials"]').html(materialList);

                    // Function to build progress messages
                    function buildProgressMessage(button) {
                        let progressMessages = [];

                        const messages = [{
                                condition: button.data('dir_approved_by') && !button.data('director_reject_reason'),
                                message: '<span style="color: green;">' + button.data('dir_approved_by') + '</span>'
                            },
                            {
                                condition: button.data('director_reject_reason') && button.data('dir_approved_by'),
                                message: '<span style="color: red;">Rejected By ' + button.data('dir_approved_by') + '(Director)</span>'
                            },
                            {
                                condition: button.data('div_approved_by') && !button.data('cluster_director_reject_reason'),
                                message: '<span style="color: green;">' + button.data('div_approved_by') + '</span>'
                            },
                            {
                                condition: button.data('cluster_director_reject_reason') && button.data('div_approved_by'),
                                message: '<span style="color: red;">Rejected by Division-Director</span>'
                            },
                            {
                                condition: button.data('hr_div_approved_by') && !button.data('hr_director_reject_reason'),
                                message: '<span style="color: green;">Approved by HR-Director</span>'
                            },
                            {
                                condition: button.data('hr_director_reject_reason') && button.data('hr_div_approved_by'),
                                message: '<span style="color: red;">Rejected by HR-Director</span>'
                            },
                            {
                                condition: button.data('transport_director_id') && !button.data('vec_director_reject_reason'),
                                message: '<span style="color: green;">Approved by Dispatcher-Director</span>',
                            },
                            {
                                condition: button.data('vec_director_reject_reason') && button.data('transport_director_id'),
                                message: '<span style="color: red;">Rejected by Dispatcher-Director</span>',
                            },
                            {
                                condition: button.data('assigned_by') && !button.data('assigned_by_reject_reason'),
                                message: '<span style="color: green;">Approved by Dispatcher</span>'
                            },
                            {
                                condition: button.data('assigned_by_reject_reason') && button.data('assigned_by'),
                                message: '<span style="color: red;">Rejected by Dispatcher</span>'
                            },
                            {
                                condition: button.data('vehicle_id'),

                                message: '<span style="color: green;">Assigned Vehicle <u>' + button.data('vehicle_plate') + '</u></span>'
                            },
                            {
                                condition: button.data('start_km'),
                                message: '<span style="color: green;">Vehicle Request <u>' + button.data('vehicle_plate') + '</u> Dispatched</span>'
                            },
                            {
                                condition: button.data('end_km'),
                                message: '<span style="color: green;">Request completed</span>'
                            },
                        ];
                        console.log(button.data('vehicle_Driver'))
                        messages.forEach(item => {
                            if (item.condition) {
                                progressMessages.push(item.message);
                            }
                        });

                        // If no conditions were met, set progress to 'Pending'
                        let progress = progressMessages.length > 0 ? progressMessages.join('<br>') : 'Pending';



                        return progress;
                    }

                    // Populate progress
                    modal.find('[data-field="progress"]').html(buildProgressMessage(button));

                });

                document.getElementById('displayprogresive').addEventListener('click', function() {
                    // Retrieve the div element to be toggled
                    var targetDiv = document.getElementById('progressbarwizard');

                    // Toggle the visibility of the div
                    if (targetDiv.style.display === 'none') {
                        targetDiv.style.display = 'block';
                    } else {
                        targetDiv.style.display = 'none';
                    }
                });

                $(document).ready(function() {

                    $(document).on('click', '.reject-reason', function() {
                        const reasons = [
                            $(this).data('reason1'),
                            $(this).data('reason2'),
                            $(this).data('reason3'),
                            $(this).data('reason4'),
                            $(this).data('reason5'),
                        ];
                        const selectedReason = reasons.find(reason => reason && reason.trim() !== '') || 'No reason provided';

                        $('#reason').val(selectedReason);
                        $('#staticBackdrop').modal('show');
                    });
                });
            </script>


            <script src="assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>


            <script src="assets/js/pages/form-wizard.init.js"></script>
            <script>
                src = "{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"
            </script>



            <!-- App js -->
            <script src="{{ asset('assets/js/app.min.js') }}"></script>
            @endsection
            <script src="{{ asset('assets/js/vendor.min.js') }}"></script>