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
                                            <h4 class="header-title mb-0">Route Registration</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('route.store') }}" accept-charset="UTF-8" name="route_registration_form" id="route_registration_form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-3">
                                                    <label class="form-label" for="vehicle">Vehicle</label>
                                                    <div class="col-mb-6">
                                                        <select id="vehicleCategory" name="vehicle_id" class="form-select" required>
                                                            <option value="">Select Vehicle</option>
                                                            @foreach($vehicles as $vehicle)
                                                                <option value="{{ $vehicle->vehicle_id }}">{{ $vehicle->plate_number }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative" >
                                                        <label class="form-label">Name</label>
                                                        <input type="text" name="route_name" class="form-control" placeholder="Enter Route Name">
        
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative">
                                                        <label class="form-label">Driver Phone Number</label>
                                                        <input type="text" name="driver_phone" id="driver_phone" class="form-control" placeholder="Enter Driver Phone Number" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Route List -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title mb-0">Route List</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lms_table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Route</th>
                                                            <th>Vehicle</th>
                                                            <th>Driver Phone</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($routes as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->route_name }}</td>
                                                            <td>{{ $data->driver_phone }}</td>
                                                            <td>{{ $data->vehicle->plate_number }}</td>
                                                            <td>
                                                                <form method="POST" action="{{ route('route.destroy',$data ) }}"accept-charset="UTF-8">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                <button type="button" class="btn btn-info rounded-pill" 
                                                                    data-bs-toggle="modal" data-bs-target="#viewRouteModal" 
                                                                    data-id="{{ $data->id }}" 
                                                                    data-route-name="{{ $data->route_name }}" 
                                                                    data-vehicle-plate="{{ $data->vehicle->plate_number }}"
                                                                    data-driver-phone="{{ $data->driver_phone }}">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                            
                                                                <button type="button" class="btn btn-secondary rounded-pill" 
                                                                    data-bs-toggle="modal" data-bs-target="#editRouteModal" 
                                                                    data-id="{{ $data->id }}" 
                                                                    data-route-name="{{ $data->route_name }}" 
                                                                    data-vehicle-id="{{ $data->vehicle_id }}" 
                                                                    data-driver-phone="{{ $data->driver_phone }}">
                                                                    <i class="ri-edit-line"></i> 
                                                                </button>
                                                                <button type="submit" class="btn btn-danger rounded-pill" title="Delete Route"
                                                                onclick="return confirm(&quot;Click OK to delete Route.&quot;)">
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
                                                                            <label for="view_route_name" class="form-label"><strong>Route Name</strong></label>
                                                                            <p id="view_route_name"></p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="view_vehicle_plate" class="form-label"><strong>Vehicle Plate</strong></label>
                                                                            <p id="view_vehicle_plate"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <label for="view_driver_phone" class="form-label"><strong>Driver Phone</strong></label>
                                                                            <p id="view_driver_phone"></p>
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
                                                                        <form id="editRouteForm" method="POST">
                                                                            @csrf
                                                                            @method('PUT') <!-- Assuming you're using RESTful update -->
                                                                            <input type="hidden" name="route_id" id="edit_route_id">
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="edit_route_name" class="form-label">Route Name</label>
                                                                                <input type="text" class="form-control" name="route_name" id="edit_route_name" required>
                                                                            </div>
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="edit_vehicle_id" class="form-label">Vehicle</label>
                                                                                <select class="form-select" name="vehicle_id" id="edit_vehicle_id" required>
                                                                                    <option value="">Select Vehicle</option>
                                                                                    @foreach($vehicles as $vehicle)
                                                                                        <option value="{{ $vehicle->vehicle_id }}">{{ $vehicle->plate_number }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="edit_driver_phone" class="form-label">Driver Phone</label>
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

                    <!-- Footer -->
                    <footer class="footer-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center mt-5">
                                    <p class="p-3 mb-0">Copyright © 2024. All rights reserved | Made By Ai</p>
                                </div>
                            </div>
                        </div>
                    </footer>
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
        document.addEventListener("DOMContentLoaded", function () {
    // View Route Modal
    document.querySelectorAll('[data-bs-target="#viewRouteModal"]').forEach(button => {
        button.addEventListener("click", function () {
            let routeId = this.getAttribute('data-id');
            let routeName = this.getAttribute('data-route-name');
            let vehiclePlate = this.getAttribute('data-vehicle-plate');
            let driverPhone = this.getAttribute('data-driver-phone');
            
            document.getElementById('view_route_name').textContent = routeName;
            document.getElementById('view_vehicle_plate').textContent = vehiclePlate;
            document.getElementById('view_driver_phone').textContent = driverPhone;
        });
    });

    // Edit Route Modal
    document.querySelectorAll('[data-bs-target="#editRouteModal"]').forEach(button => {
        button.addEventListener("click", function () {
            let routeId = this.getAttribute('data-id');
            let routeName = this.getAttribute('data-route-name');
            let vehicleId = this.getAttribute('data-vehicle-id');
            let driverPhone = this.getAttribute('data-driver-phone');
            
            document.getElementById('edit_route_id').value = routeId;
            document.getElementById('edit_route_name').value = routeName;
            document.getElementById('edit_vehicle_id').value = vehicleId;
            document.getElementById('edit_driver_phone').value = driverPhone;

            document.getElementById('editRouteForm').action = `/routes/${routeId}`;
        });
    });
});

    </script>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

@endsection
