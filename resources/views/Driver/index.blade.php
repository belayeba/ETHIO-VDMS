@extends('layouts.navigation')
@section('content')

<div class="wrapper">
    <div class="content-page">
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
        <div class="preloader" dir="ltr">
            <div class='body'>
                <span>
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <div class='base'>
                    <span></span>
                    <div class='face'></div>
                </div>
            </div>
            <div class='longfazers'>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <input type="hidden" name="table_name" id="table_name" value="">
        <input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">


        <div class="main-wrapper" style="min-height: 600px">
            <!-- Page Content  -->
            <div id="main-content" class="">
                <section class="sms-breadcrumb mb-10 white-box">
                    <div class="container-fluid p-0">

                    </div>
                </section>

                <section class="admin-visitor-area up_st_admin_visitor">
                    <div class="container-fluid p-0">
                        <div class="row justify-content-center">

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0">@lang('messages.Driver Registration')</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('driver.store') }}" accept-charset="UTF-8" name="driver_registration-form" id="driver_registration-form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mb-3">
                                                <label class="col-md-3 col-form-label" for="user_id">@lang('messages.Driver')</label>
                                                <div class="col-md-9">
                                                    <select id="user_id" name="user_id" class="form-select" required>
                                                        <option value="">@lang('messages.Select Driver')</option>
                                                        @foreach($drivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->first_name }} {{ $driver->middle_name }} {{ $driver->last_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nameInput" class="form-label">@lang('messages.License')<strong class="text-danger">*</strong></label>
                                                <input type="file" class="form-control" id="license_file" name="license_file" placeholder="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nameInput" class="form-label">@lang('messages.License Number')<strong class="text-danger">*</strong></label>
                                                <input type="text" class="form-control" id="license_number" name="license_number" placeholder=@lang('messages.Enter driving License Number')>
                                            </div>
                                            <div class="position-relative mb-3">
                                                <div class="mb-6 position-relative" id="datepicker1">
                                                    <label class="form-label">@lang('messages.License expiry date') </label>
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
                                            <div class="mb-3">
                                                <label for="nameInput" class="form-label"> @lang('messages.Notes')<strong class="text-danger">*</strong></label>
                                                <input type="text" class="form-control" id="notes" name="notes" placeholder="Notes">
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0">@lang('messages.Driver List')</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="lms_table" class="table">
                                                <thead>
                                                    <tr>
                                                        <th> {{' # '}} </th>
                                                        <th>{{ __('messages.Driver') }}</th>
                                                        <th>{{ __('messages.Phone Number') }}</th>
                                                        <th>{{ __('messages.Status') }}</th>
                                                        <th>{{ __('messages.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $item)
                                                    {{-- {{ dd($item->license_file) }} --}}
                                                    <tr>
                                                        <!-- Table rows will be populated here -->
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $item->user->first_name }} {{ $item->user->middle_name }}</td>
                                                        <td>{{ $item->user->phone_number }}</td>
                                                        <td>
                                                            <!-- Create a toggle switch for status -->
                                                            <label class="switch">
                                                                <input type="checkbox" class="status-toggle" data-id="{{ $item->driver_id }}" {{ $item->status == 'active' ? 'checked' : '' }}>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <form method="POST" action="" accept-charset="UTF-8">
                                                                @method('DELETE')
                                                                <input name="_method" value="DELETE" type="hidden">
                                                                {{ csrf_field() }}
                                                                <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" title="View Driver" data-bs-target="#viewDriverModal{{ $item->driver_id }}">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>

                                                                <button type="button" class="btn btn-secondary rounded-pill" title="Edit Driver"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#driver_modal_{{$loop->index}}"
                                                                    data-driver-name="{{ $driver->first_name }} {{ $driver->last_name }}"
                                                                    data-driver-phone="{{ $item->user->phone_number }}"
                                                                    data-license="{{ $item->license_file }}"
                                                                    data-licenseNumber="{{ $item->license_number }}"
                                                                    data-licenseExpiry="{{ $item->license_expiry_date }}">
                                                                    <i class="ri-edit-line"></i>
                                                                </button>

                                                                <button type="button" class="btn btn-danger rounded-pill" title="Delete Driver"
                                                                    data-bs-toggle="modal" data-bs-target="#warning_alert">
                                                                    <i class="ri-close-circle-line"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <div id="driver_modal_{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <form method="POST" action="{{ route('driver.update', $item) }}" class="ps-3 pe-3" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="driver_id" value="{{ $item->driver_id }}">

                                                                        {{-- <div class="mb-3">
                                                                                <label for="name" class="form-label">@lang('messages.Driver')</label>
                                                                                <select id="name" name="user_id" class="form-select" required>
                                                                                  @foreach($data as $driver)
                                                                                    <option value="{{ $driver->user_id }}" {{ $driver->user_id == $item->user_id ? 'selected' : '' }}>
                                                                        {{ $driver->user->username }}
                                                                        </option>
                                                                        @endforeach
                                                                        </select>
                                                                </div> --}}

                                                                <div class="mb-3">
                                                                    <label for="license{{ $loop->index }}" class="form-label">@lang('messages.License')</label>
                                                                    <input class="form-control" type="file" name="license_file" id="license{{ $loop->index }}" value="{{ $item->license_file }}">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="licenseNumber{{ $loop->index }}" class="form-label">@lang('messages.License Number')</label>
                                                                    <input class="form-control" type="text" name="license_number" id="licenseNumber{{ $loop->index }}" value="{{ $item->license_number }}">
                                                                </div>


                                                                <div class="position-relative mb-3">
                                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                                        <label for="licenseExpiry{{ $loop->index }}" class="form-label">@lang('messages.License expiry date')</label>
                                                                        <input class="form-control" type="text" name="license_expiry_date" id="licenseExpirydate{{ $loop->index }}" value="{{ $item->license_expiry_date }}">
                                                                    </div>

                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="notes{{ $loop->index }}" class="form-label">@lang('messages.Notes')</label>
                                                                    <input class="form-control" type="text" name="notes" id="notes{{ $loop->index }}" value="{{ $item->notes }}">
                                                                </div>

                                                                <div class="mb-3 text-center">
                                                                    <script>
                                                                        $('#licenseExpirydate{{ $loop->index }}').calendarsPicker({
                                                                            calendar: $.calendars.instance('ethiopian', 'am'),
                                                                            pickerClass: 'myPicker',
                                                                            dateFormat: 'yyyy-mm-dd'
                                                                        });
                                                                    </script>
                                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                                    <a type="button" href="{{ route('driver.index') }}" class="btn btn-warning">Cancel</a>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                        </div>
                                        <div class="modal fade" id="viewDriverModal{{ $item->driver_id }}" tabindex="-1" aria-labelledby="viewDriverModalLabel{{ $item->driver_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewDriverModalLabel{{ $item->driver_id }}">@lang('messages.Driver Details')</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('messages.Name'):</label>
                                                            <p>{{ $item->user->first_name }} {{ $item->user->middle_name }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('messages.Phone Number'):</label>
                                                            <p>{{ $item->user->phone_number }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('messages.License Number'):</label>
                                                            <p>{{ $item->license_number }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('messages.License expiry date')</label>
                                                            <p>{{ $item->license_expiry_date }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('messages.Driving License')</label>
                                                            @if($item->license_file)
                                                            <p><a href="{{ Storage::url('Drivers/' . $item->license_file) }}" target="_blank">View File</a></p>
                                                            @else
                                                            <p>No file uploaded</p>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">@lang('messages.Notes'):</label>
                                                            <p>{{ $item->notes }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Accept Alert Modal -->
                                        <div id="warning_alert" class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('driver.destroy',$item) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="request_id" id="request_id">
                                                        <div class="modal-body p-4">
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-warning"></i>
                                                                <h4 class="mt-2">Warning</h4>
                                                                <h5 class="mt-3">
                                                                    @lang('messages.Are you sure you want to accept this request?')</br> @lang('messages.This action cannot be undone.')
                                                                </h5>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">@lang('messages.Cancel')</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    id="confirmDelete">@lang('messages.Yes, Accept')</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                        @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>
        </div>
    </div>
</div>
</div>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 34px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 50px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 12px;
        width: 12px;
        border-radius: 50px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
    }

    input:checked+.slider {
        background-color: #4CAF50;
    }

    input:checked+.slider:before {
        transform: translateX(14px);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Define the route URL directly in JavaScript
    var routeUrl = "{{ route('driver.status') }}"; // Use Blade to generate the route URL

    // Listen for the change event on the checkbox
    $(document).ready(function() {
        $('.status-toggle').on('change', function() {
            var status = $(this).prop('checked') ? 'active' : 'inactive'; // Set status to 'active' if checked, 'inactive' if unchecked
            var itemId = $(this).data('id'); // Get the item toogle- from the checkbox

            // Send an AJAX request to update the status on the server
            $.ajax({
                url: routeUrl,
                type: 'POST',
                data: {
                    id: itemId,
                    status: status,
                    _token: '{{ csrf_token() }}' // CSRF token
                },
                success: function(response) {
                    // Trigger a page reload to show session messages
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Trigger a page reload to show error message
                    window.location.reload();
                }
            });

        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var viewButtons = document.querySelectorAll('.view-driver-btn');

        viewButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var driverName = this.getAttribute('data-driver-name');
                var phone = this.getAttribute('data-driver-phone');
                var license = this.getAttribute('data-driver-license'); // This is the file path or name
                var licenseNumber = this.getAttribute('data-license-number');
                var licenseExpiry = this.getAttribute('data-license-expiry');
                var index = this.getAttribute('data-bs-target').split('_').pop();

                // Populate the modal with the selected driver's details
                document.getElementById('view_name' + index).innerText = driverName;
                document.getElementById('view_phone' + index).innerText = phone;
                document.getElementById('view_license' + index).innerText = license;
                document.getElementById('view_licenseNumber' + index).innerText = licenseNumber;
                document.getElementById('view_licenseExpiry' + index).innerText = licenseExpiry;
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-driver-btn');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var driverName = this.getAttribute('data-driver-name');
                var phone = this.getAttribute('data-driver-phone');
                var license = this.getAttribute('data-license');
                var licenseNumber = this.getAttribute('data-licenseNumber');
                var licenseExpiry = this.getAttribute('data-licenseExpiry');
                var index = this.getAttribute('data-bs-target').split('_').pop();

                // Populate the modal input fields with the selected driver's details
                document.getElementById('name' + index).value = driverName;
                document.getElementById('phone' + index).value = phone;
                document.getElementById('license' + index).value = license;
                document.getElementById('licenseNumber' + index).value = licenseNumber;
                document.getElementById('licenseExpiry' + index).value = licenseExpiry;
            });
        });
    });
</script>
<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<!-- App js -->
<script src="assets/js/app.min.js"></script>

@endsection