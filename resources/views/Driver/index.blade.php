@extends('layouts.navigation')
@section('content')

    <div class="wrapper">
        <div class="content-page">
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
                            {{-- <div class="d-flex flex-wrap justify-content-between">
                                <h2 class="text-uppercase">Cluster</h2>
                                <div class="bc-pages">
                                    
                                </div>
                            </div> --}}
                        </div>
                    </section>

                    <section class="admin-visitor-area up_st_admin_visitor">
                        <div class="container-fluid p-0">
                            <div class="row justify-content-center">
                                <!-- Add New Cluster Form -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Driver Registration</h3>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('driver.store') }}" accept-charset="UTF-8" name="driver_registration-form" id="driver_registration-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="user_id">Driver</label>
                                                    <div class="col-md-9">
                                                        <select id="user_id" name="user_id" class="form-select" required>
                                                            <option value="">Select Driver</option>
                                                            @foreach($drivers as $driver)
                                                                <option value="{{ $driver->id }}">{{ $driver->username }}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">License<strong class="text-danger">*</strong></label>
                                                    <input type="file" class="form-control" id="license_file" name="license_file" placeholder="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">License Number <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="license_number" name="license_number" placeholder="Enter License Number">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">License expiry date <strong class="text-danger">*</strong></label>
                                                    <input type="date" class="form-control" id="license_expiry_date" name="license_expiry_date" placeholder="Enter License expiry date">
                                                </div>
                                                {{-- <div class="mb-3">
                                                    <label for="nameInput" class="form-label"> Phone Number<strong class="text-danger">*</strong></label>
                                                    <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number">
                                                </div> --}}
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label"> Notes<strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="notes" name="notes" placeholder="Notes">
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Cluster List -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Driver List</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lms_table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th> {{' # '}} </th>
                                                            <th>{{ 'Driver' }}</th>
                                                            <th>{{ 'Phone Number' }}</th>
                                                            <th>{{ 'Status' }}</th>
                                                            <th>{{ 'Action' }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         @foreach ($data as $item)
                                                         {{-- {{ dd($item->user->username) }} --}}
                                                        <tr>
                                                        <!-- Table rows will be populated here -->
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $item->user->username }}</td>
                                                        <td>{{ $item->user->phone_number }}</td>
                                                        <td>{{ $item->status }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('driver.destroy',$item) }}"accept-charset="UTF-8">
                                                                @method('DELETE')
                                                                <input name="_method" value="DELETE" type="hidden">
                                                                {{ csrf_field() }}
                                                                <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" title="View Driver" data-bs-target="#viewDriverModal{{ $item->driver_id }}">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>

                                                                <button type="button" class="btn btn-primary edit-driver-btn" title="Edit Driver"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#driver_modal_{{$loop->index}}"
                                                                data-driver-name="{{ $item->user->username }}"
                                                                data-driver-phone="{{ $item->user->phone_number }}"
                                                                data-license ="{{ $item->license_file }}"
                                                                data-licenseNumber ="{{ $item->license_number }}"
                                                                data-licenseExpiry  ="{{ $item->license_expiry_date }}">
                                                                <i class="ri-edit-line"></i> 
                                                            </button>
                                                            
                                                            <button type="submit" class="btn btn-danger rounded-pill" title="Delete Driver"
                                                                onclick="return confirm(&quot;Click OK to delete Driver.&quot;)">
                                                                <i class="ri-close-circle-line"></i>
                                                            </button>
                                                          </form>
                                                         </td> 
                                                        </tr>
                                                        <div id="driver_modal_{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <form method="POST" action="{{ route('driver.update', $item) }}" class="ps-3 pe-3">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="driver_id" value="{{ $item->driver_id }}">
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="name{{ $loop->index }}" class="form-label">Name</label>
                                                                                <input class="form-control" type="text" name="name" id="name{{ $loop->index }}" value="{{ $item->user->username }}">
                                                                            </div>
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="phone{{ $loop->index }}" class="form-label">Phone Number</label>
                                                                                <input class="form-control" type="text" name="phone" id="phone{{ $loop->index }}" value="{{ $item->user->phone_number }}">
                                                                            </div>
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="license{{ $loop->index }}" class="form-label">License</label>
                                                                                <input class="form-control" type="file" name="license" id="license{{ $loop->index }}" value="{{ $item->license_file }}">
                                                                            </div>
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="licenseNumber{{ $loop->index }}" class="form-label">License Number</label>
                                                                                <input class="form-control" type="text" name="licenseNumber" id="licenseNumber{{ $loop->index }}" value="{{ $item->license_number }}">
                                                                            </div>
                                                        
                                                                            <div class="mb-3">
                                                                                <label for="licenseExpiry{{ $loop->index }}" class="form-label">License Expiry Date</label>
                                                                                <input class="form-control" type="date" name="licenseExpiry" id="licenseExpiry{{ $loop->index }}" value="{{ $item->license_expiry_date }}">
                                                                            </div>
                                                        
                                                                            <div class="mb-3 text-center">
                                                                                <button class="btn btn-primary" type="submit">Update</button>
                                                                                <a type="button" href="{{ route('driver.index') }}" class="btn btn-warning">Cancel</a>
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
                    <div class="modal fade" id="viewDriverModal{{ $item->driver_id }}" tabindex="-1" aria-labelledby="viewDriverModalLabel{{ $item->driver_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDriverModalLabel{{ $item->driver_id }}">Driver Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <p>{{ $item->user->username }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number:</label>
                    <p>{{ $item->user->phone_number }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">License Number:</label>
                    <p>{{ $item->license_number }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">License Expiry Date:</label>
                    <p>{{ $item->license_expiry_date }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">License File:</label>
                    @if($item->license_file)
                        <p><a href="{{ Storage::url($item->license_file) }}" target="_blank">View File</a></p>
                    @else
                        <p>No file uploaded</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes:</label>
                    <p>{{ $item->notes }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

                    
                    
                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteLabel">Delete Confirmation</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Are you sure to delete ?</p>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <a id="delete_link" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var viewButtons = document.querySelectorAll('.view-driver-btn');

    viewButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var driverName = this.getAttribute('data-driver-name');
            var phone = this.getAttribute('data-driver-phone');
            var license = this.getAttribute('data-driver-license');  // This is the file path or name
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