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
                                            <h4 class="header-title mb-0">Change Driver</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('driver_change.store') }}" accept-charset="UTF-8" 
                                                name="driver_change-form" id="driver_change-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="vehicle">Vehicle</label>
                                                    <div class="col-md-9">
                                                        <select id="vehicleCategory" name="vehicle_id" class="form-select" required>
                                                            <option value="">Select Vehicle</option>
                                                            @foreach($vehicles as $vehicle)
                                                                <option value="{{ $vehicle->vehicle_id }}">{{ $vehicle->plate_number }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small id="vehicleError" class="text-danger d-none">Please select a vehicle.</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="driver">New Driver</label>
                                                    <div class="col-md-9">
                                                        <select id="driver" name="driver" class="form-select" required>
                                                            <option value="">Select Driver</option>
                                                            @foreach($drivers as $driver)
                                                                <option value="{{ $driver->driver_id }}">{{ $driver->user->first_name }} {{ $driver->user->middle_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small id="driverError" class="text-danger d-none">Please select a driver.</small>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Driver Change List -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title mb-0">Driver List</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lms_table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Vehicle</th>
                                                            <th>Old Driver</th>
                                                            <th>New Driver</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($driverChange->isNotEmpty())
                                                        @foreach ($driverChange as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->vehicle->plate_number }}</td>
                                                                <td>{{ $item->oldDriver?$item->oldDriver->user->username:"No previous Driver" }}</td> 
                                                                <td>{{ $item->newDriver->user->username ?? null }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" title="View Driver Change" data-bs-target="#viewDriverChangeModal{{ $item->id }}">
                                                                        <i class="ri-eye-line"></i>
                                                                    </button>
                                                    
                                                                    <button type="button" class="btn btn-secondary rounded-pill" title="Edit Driver Change"
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#editDriverChangeModal_{{ $loop->index }}"
                                                                        data-vehicle="{{ $item->vehicle->model }}"
                                                                        data-old-driver="{{ $item->oldDriver?$item->oldDriver->user->username:'No previous driver' }}"
                                                                        data-new-driver="{{ $item->newDriver->user->username ?? "None" }}">
                                                                        <i class="ri-edit-line"></i> 
                                                                    </button>
                                                    
                                                                    @if (($item->driver_accepted == false))
                                                                    <button type="button" class="btn btn-danger rounded-pill" title="Delete Driver Change"
                                                                        data-bs-toggle="modal" data-bs-target="#warning_alert">
                                                                    <i class="ri-close-circle-line"></i>
                                                                    </button>
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <div id="warning_alert" class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                                            aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                                            <div class="modal-dialog modal-sm">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="{{ route('driverchange.destroy',$item->driver_change_id) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="request_id" id="request_id">
                                                                        <div class="modal-body p-4">
                                                                            <div class="text-center">
                                                                                <i class="ri-alert-line h1 text-warning"></i>
                                                                                <h4 class="mt-2">Warning</h4>
                                                                                <h5 class="mt-3">
                                                                                    Are you sure you want to delete this driver change?</br> This action
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
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <!-- View Modal for Driver Change -->
                            @foreach ($driverChange as $item)
                            <div class="modal fade" id="viewDriverChangeModal{{ $item->id }}" tabindex="-1" aria-labelledby="viewDriverChangeLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewDriverChangeLabel{{ $item->id }}">View Driver Change</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                    <label for="vehicle" class="form-label">Vehicle</label>
                                    <input type="text" class="form-control" id="vehicle" value="{{ $item->vehicle->model }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                    <label for="oldDriver" class="form-label">Old Driver</label>
                                    <input type="text" class="form-control" id="oldDriver" value="{{ $item->oldDriver?$item->oldDriver->user->username:'No former Driver' }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                    <label for="newDriver" class="form-label">New Driver</label>
                                    <input type="text" class="form-control" id="newDriver" value="{{ $item->newDriver->user->username ?? "None" }}" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>
                            @endforeach

                            <!-- Edit Modal for Driver Change -->
                            @if ($driverChange->isNotEmpty())
                            @foreach ($driverChange as $item)
                            <div class="modal fade" id="editDriverChangeModal_{{ $loop->index }}" tabindex="-1" aria-labelledby="editDriverChangeLabel{{ $loop->index }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDriverChangeLabel{{ $loop->index }}">Edit Driver Change</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('driverchange.update', ['request_id' => $item->driver_change_id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="vehicle" class="form-label">Vehicle</label>
                                        <select id="vehicle" name="vehicle_id" class="form-select" required>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->vehicle_id }}" {{ $vehicle->vehicle_id == $item->vehicle_id ? 'selected' : '' }}>{{ $vehicle->plate_number }}</option>
                                        @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="oldDriver" class="form-label">Old Driver</label>
                                        <select id="oldDriver" name="old_driver_id" class="form-select" required>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->driver_id }}" {{ $driver->driver_id == $item->old_driver_id ? 'selected' : '' }}>{{ $driver->user->username }}</option>
                                        @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="newDriver" class="form-label">New Driver</label>
                                        <select id="newDriver" name="new_driver_id" class="form-select" required>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->driver_id }}" {{ $driver->driver_id == $item->new_driver_id ? 'selected' : '' }}>{{ $driver->user->username }}</option>
                                        @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                        </div>
                    </section>

                    
                </div>
            </div>
        </div>
    </div>
   <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Event listener for Edit button
    document.querySelectorAll('.edit-driver-change-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            // Get data from the clicked button's data attributes
            let vehicle = this.getAttribute('data-vehicle');
            let oldDriver = this.getAttribute('data-old-driver');
            let newDriver = this.getAttribute('data-new-driver');

            // Find the modal and populate its fields
            let modal = document.querySelector('#editDriverChangeModal_' + this.getAttribute('data-bs-target').split('_')[1]);
            modal.querySelector('#vehicle').value = vehicle;
            modal.querySelector('#oldDriver').value = oldDriver;
            modal.querySelector('#newDriver').value = newDriver;
        });
    });
});

   </script>

<script>
    document.getElementById('driver_change-form').addEventListener('submit', function(event) {
        let isValid = true;
    
        // Get input elements
        let vehicle = document.getElementById('vehicleCategory');
        let driver = document.getElementById('driver');
        
        // Get error messages
        let vehicleError = document.getElementById('vehicleError');
        let driverError = document.getElementById('driverError');
    
        // Validate vehicle selection
        if (vehicle.value === "") {
            vehicleError.classList.remove('d-none');
            isValid = false;
        } else {
            vehicleError.classList.add('d-none');
        }
    
        // Validate driver selection
        if (driver.value === "") {
            driverError.classList.remove('d-none');
            isValid = false;
        } else {
            driverError.classList.add('d-none');
        }
    
        // If validation fails, prevent form submission
        if (!isValid) {
            event.preventDefault();
        }
    });
    </script>
    

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

@endsection
