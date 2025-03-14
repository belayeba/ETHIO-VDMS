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
            <div id="main-content">
                <section class="sms-breadcrumb mb-10 white-box">
                    <div class="container-fluid p-0">
                        <!-- Add any breadcrumb content here if needed -->
                    </div>
                </section>

                <section class="admin-visitor-area up_st_admin_visitor">
                    <div class="container-fluid p-0">
                        <div class="row justify-content-center">

                            <!-- Driver Change Form -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0">@lang('messages.Route Registration')</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('route.store') }}" accept-charset="UTF-8" name="route_registration_form" id="route_registration_form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="position-relative mb-3">
                                                <div class="mb-6 position-relative">
                                                    <label class="form-label">Route Name</label>
                                                    <input type="text" name="route_name" class="form-control" placeholder="Enter Route Name">

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="form-label" for="vehicle">@lang('messages.Vehicle')</label>
                                                <div class="col-mb-6">
                                                    <select id="vehicleCategory" name="vehicle_id" class="form-select" required>
                                                        <option value="">@lang('messages.Select Vehicle')</option>
                                                        @foreach($vehicles as $vehicle)
                                                        <option value="{{ $vehicle->vehicle_id }}">{{ $vehicle->plate_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="position-relative mb-3">
                                                <div class="mb-6 position-relative">
                                                    <label class="form-label">@lang('messages.Driver Name')</label>
                                                    <input type="text" name="driver_name" id="driver_name" class="form-control" placeholder="Enter Driver Name" required>
                                                </div>
                                            </div>
                                            <div class="position-relative mb-3">
                                                <div class="mb-6 position-relative">
                                                    <label class="form-label">@lang('messages.Driver Phone number')</label>
                                                    <input type="text" name="driver_phone" id="driver_phone" class="form-control" placeholder="Enter Driver Phone Number" required>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" id="route_registration_form_submit" class="btn btn-primary">@lang('messages.save')</button>
                                            </div>

                                            <script>
                                                document.getElementById('route_registration_form').addEventListener('submit', function() {
                                                    let button = document.getElementById('route_registration_form_submit');
                                                    button.disabled = true;
                                                    button.innerText = "Processing..."; // Optional: Change text to indicate processing
                                                });

                                            </script>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Route List -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0">@lang('messages.Route List')</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="lms_table" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ __('messages.Route') }}</th>
                                                        <th>{{ __('messages.Vehicle') }}</th>
                                                        <th>{{ __('messages.Driver Phone number') }}</th>
                                                        <th>{{ __('messages.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($routes as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->route_name }}</td>
                                                        <td>{{ $data->vehicle->plate_number }}</td>
                                                        <td>{{ $data->driver_phone }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('route.destroy',$data ) }}" accept-charset="UTF-8">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-info rounded-pill"
                                                                    data-bs-toggle="modal" data-bs-target="#viewRouteModal"
                                                                    data-id="{{ $data->id }}"
                                                                    data-route-name="{{ $data->route_name }}"
                                                                    data-driver="{{ $data->driver_name }}"
                                                                    data-vehicle-plate="{{ $data->vehicle->plate_number }}"
                                                                    data-driver-phone="{{ $data->driver_phone }}">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>

                                                                <button type="button" class="btn btn-secondary rounded-pill"
                                                                    data-bs-toggle="modal" data-bs-target="#editRouteModal"
                                                                    data-id="{{ $data->route_id }}"
                                                                    data-route-name="{{ $data->route_name }}"
                                                                    data-vehicle-id="{{ $data->vehicle_id }}"
                                                                    data-driver-phone="{{ $data->driver_phone }}"
                                                                    data-driver-name="{{ $data->driver_name }}">
                                                                    <i class="ri-edit-line"></i>
                                                                </button>

                                                                <button type="button" class="btn btn-danger rounded-pill" title="Delete Route"
                                                                    data-bs-toggle="modal" data-bs-target="#warning_alert">
                                                                    <i class="ri-close-circle-line"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <!-- View Route Modal -->
                                                    <div class="modal fade" id="viewRouteModal" tabindex="-1" role="dialog" aria-labelledby="viewRouteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewRouteModalLabel">View Route Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <label for="view_route_name" class="form-label"><strong>@lang('messages.Route')</strong></label>
                                                                            <p id="view_route_name"></p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="view_vehicle_plate" class="form-label"><strong>@lang('messages.Vehicle')</strong></label>
                                                                            <p id="view_vehicle_plate"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <label for="view_driver_phone" class="form-label"><strong>@lang('messages.Driver Phone number')</strong></label>
                                                                            <p id="view_driver_phone"></p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="view_driver_name" class="form-label"><strong>@lang('messages.Driver Name')</strong></label>
                                                                            <p id="view_driver_name"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="editRouteModal" tabindex="-1" role="dialog" aria-labelledby="editRouteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editRouteModalLabel">Edit Route Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('route.updates', $data->route_id) }}" id="editRouteForm" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="route_id" id="edit_route_id">

                                                                        <div class="mb-3">
                                                                            <label for="edit_route_name" class="form-label">@lang('messages.Route')</label>
                                                                            <input type="text" class="form-control" name="route_name" id="edit_route_name" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="edit_vehicle_id" class="form-label">@lang('messages.Vehicle')</label>
                                                                            <select class="form-select" name="vehicle_id" id="edit_vehicle_id" required>
                                                                                <option value="">@lang('messages.Select Vehicle')</option>
                                                                                @foreach($vehicles as $vehicle)
                                                                                <option value="{{ $vehicle->vehicle_id }}">{{ $vehicle->plate_number }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="edit_driver_phone" class="form-label">Driver Name</label>
                                                                            <input type="text" class="form-control" name="driver_name" id="edit_driver_name" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="edit_driver_phone" class="form-label">@lang('messages.Driver Phone number')</label>
                                                                            <input type="text" class="form-control" name="driver_phone" id="edit_driver_phone" required>
                                                                        </div>

                                                                        <div class="text-center">
                                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Accept Alert Modal -->
                                                    <div id="warning_alert" class="modal fade" id="confirmationModal"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <form method="POST" action="{{ route('route.destroy',$data) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="request_id" id="request_id">
                                                                    <div class="modal-body p-4">
                                                                        <div class="text-center">
                                                                            <i class="ri-alert-line h1 text-warning"></i>
                                                                            <h4 class="mt-2">Warning</h4>
                                                                            <h5 class="mt-3">
                                                                                Are you sure you want to delete this Route?</br> This
                                                                                action
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
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.7/inputmask.min.js"></script>
<script>
    // Mask for Ethiopian phone numbers (local and international formats)
    Inputmask({
        mask: ["(0)999999999", "+251 999999999"],
        greedy: false,
        keepStatic: true
    }).mask("#phone");
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // View Route Modal
        document.querySelectorAll('[data-bs-target="#viewRouteModal"]').forEach(button => {
            button.addEventListener("click", function() {
                let routeId = this.getAttribute('data-id');
                let routeName = this.getAttribute('data-route-name');
                let vehiclePlate = this.getAttribute('data-vehicle-plate');
                let driverPhone = this.getAttribute('data-driver-phone');
                let driverName = this.getAttribute('data-driver');

                document.getElementById('view_route_name').textContent = routeName;
                document.getElementById('view_vehicle_plate').textContent = vehiclePlate;
                document.getElementById('view_driver_phone').textContent = driverPhone;
                document.getElementById('view_driver_name').textContent = driverName;
            });
        });

        // Edit Route Modal
        document.querySelectorAll('[data-bs-target="#editRouteModal"]').forEach(button => {
            button.addEventListener("click", function() {
                let routeId = this.getAttribute('data-id');
                let routeName = this.getAttribute('data-route-name');
                let vehicleId = this.getAttribute('data-vehicle-id');
                let driverPhone = this.getAttribute('data-driver-phone');
                let driverName = this.getAttribute('data-driver-name');
                document.getElementById('edit_route_id').value = routeId;
                document.getElementById('edit_route_name').value = routeName;
                document.getElementById('edit_vehicle_id').value = vehicleId;
                document.getElementById('edit_driver_phone').value = driverPhone;
                document.getElementById('edit_driver_name').value = driverName;
                document.getElementById('editRouteForm').action = `/Route/update/${routeId}`;
            });
        });
    });
</script>

<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>

@endsection