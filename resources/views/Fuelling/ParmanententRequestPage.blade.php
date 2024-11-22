@extends('layouts.navigation')

@section('content')
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
                                <h4 class="header-title">Fuel Request</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('store_fuel_request') }}" method="POST" enctype="multipart/form-data" id="fuelForm">
                                    @csrf
                                    <div>
                                        <label>Vehicle</label>
                                        @if ($vehicles)
                                            <select name="vehicle_id" class="form-select mb-3">
                                                <option selected>Open this select menu</option>
                                                    @foreach($vehicles as $vehicle)
                                                        <option value="{{$vehicle->vehicle_id}}">{{$vehicle->vehicle->plate_number}}</option>
                                                    @endforeach
                                            </select> 
                                        @endif
                                    </div>

                                    <div>
                                        <label>Vehicle</label>
                                        <input name="year" type="number" placeholder="Enter year (2010 - 2050)" class="form-control mb-3" min="2010" max="2050"/>
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Select Month</label>
                                        <select class="form-select mb-3" name="month">
                                            <option value="">Select</option>
                                            <option value="1">መስከረም</option>
                                            <option value="2">ጥቅምት</option>
                                            <option value="3">ኅዳር</option>
                                            <option value="4">ታህሣሥ</option>
                                            <option value="5">ጥር</option>
                                            <option value="6">የካቲት</option>
                                            <option value="7">መጋቢት</option>
                                            <option value="8">ሚያዝያ</option>
                                            <option value="9">ግንቦት</option>
                                            <option value="10">ሰኔ</option>
                                            <option value="11">ሐምሌ</option>
                                            <option value="12">ነሐሴ</option>
                                            <option value="13">ጳጉሜ</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Entries Container -->
                                    <div id="entriesContainer"></div>
                                    
                                    <!-- Buttons: Add and Submit (aligned to the right) -->
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" id="addItem" class="btn btn-primary rounded-pill">Add</button>
                                        <button type="submit" class="btn btn-info ms-3">Submit</button>
                                    </div>
                                </form>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const addButton = document.getElementById('addItem');
                                        const entriesContainer = document.getElementById('entriesContainer');
                                        let entryCount = 0;
                                
                                        // Add button event listener
                                        addButton.addEventListener('click', function() {
                                            const index = entryCount++;
                                            const entryDiv = document.createElement('div');
                                            entryDiv.classList.add('entry', 'mt-3');
                                            
                                            entryDiv.innerHTML = `
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Fuel</label>
                                                        <input name="fuel_amount[${index}]" class="form-control" placeholder="In Liters" type="number" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Price</label>
                                                        <input name="fuel_cost[${index}]" class="form-control" placeholder="In Birr" type="number" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>Date</label>
                                                        <input name="fuiling_date[${index}]" class="form-control datepicker" placeholder="When" id="fill_date" type="date" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Attachment</label>
                                                        <input name="reciet_attachment [${index}]" class="form-control" type="file" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm removeEntry">x</button>
                                                    </div>
                                                </div>
                                            `;
                                            
                                            // Append new entry to the container
                                            entriesContainer.appendChild(entryDiv);
                                
                                        });
                                
                                        // Event delegation for delete buttons (remove entry)
                                        entriesContainer.addEventListener('click', function(e) {
                                            if (e.target.classList.contains('removeEntry')) {
                                                const entryDiv = e.target.closest('.entry');
                                                entryDiv.remove();  // Remove the entry
                                            }
                                        });
                                    });
                                </script>
                          
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>


                    <!-- Ebook List -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title mb-0">Request List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table fuel_datatable table-centered mb-0 table-nowrap" id="inline-editable">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Vehicle Plate</th>
                                                <th scope="col">Fuel Amount</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table rows will be populated here -->
                                            {{-- @foreach($fuelings as $request) --}}
                                            {{-- {{dd($fuelings)}} --}}
                                                <tbody>
                                                    {{-- <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->vehicle->plate_number}}</td>
                                                        <td>status</td>
                                                        <td>{{$request->month}}/{{$request->year}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill" title="Inspect" id="assignBtn-{{$loop->iteration}}">Show</button>
                                  
                                                            <input type="hidden" name="id" id="IdSelection-{{$loop->iteration}}" value="{{$request->fueling_id}}" id="vehicleselection">

                                                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>
                                                           
                                                        </td> --}}
                                                    </tr>
                                                </tbody>
                                            </table>
                                                <!-- this is for the assign  modal -->
                                                {{-- <div class="modal fade" id="staticaccept-{{$loop->iteration}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            
                                                                <div class="modal-header">
                                                                                                                                    
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div> <!-- end modal header -->
                                                                <div class="modal-body d-flex flex-column align-items-center">
                                                                    <div class="row mt-3 w-100" id="inspectionCardsContainer-{{$loop->iteration}}">
                                                                    </div>
                                                                    
                                                                    <!-- Image Preview Section -->
                                                                    <div>
                                                                        <iframe id="filePreview-{{$loop->iteration}}" 
                                                                             style="width: 100%;
                                                                                    height: 500px; 
                                                                                    display: none;
                                                                                    ">
                                                                        </iframe>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">close</button>
                                                                </div> <!-- end modal footer -->
                                                            </div>                                                              
                                                        </div> <!-- end modal content-->
                                                    </div> <!-- end modal dialog--> --}}


                                {{-- modal for displaying the data --}}
                                <div class="modal fade" id="staticaccept" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            
                                                <div class="modal-header">
                                                                                                                    
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div> <!-- end modal header -->
                                                <div class="modal-body d-flex flex-column align-items-center">
                                                    <div class="row mt-3 w-100" id="inspectionCardsContainer">
                                                    </div>
                                                    
                                                    <!-- Image Preview Section -->
                                                    <div>
                                                        <iframe id="filePreview" 
                                                                style="width: 100%;
                                                                    height: 500px; 
                                                                    display: none;
                                                                    ">
                                                        </iframe>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">close</button>
                                                </div> <!-- end modal footer -->
                                            </div>                                                              
                                        </div> <!-- end modal content-->
                                    </div> <!-- end modal dialog-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                    aria-labelledby="confirmationModalLabel"aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('perm_vec_director_approve') }}">
                                @csrf
                                <input type="hidden" name="request_id" id="request_id">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="ri-alert-line h1 text-danger"></i>
                                        <h4 class="mt-2">Warning</h4>
                                        <h5 class="mt-3">
                                            Are you sure you want to accept this request?</br> This action
                                            cannot be
                                            undone.
                                        </h5>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger"
                                            id="confirmDelete">Yes,
                                            Accept</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

        <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
                
        <script>

            var table = $('.fuel_datatable').DataTable({
                processing: true,
                pageLength: 3,
                serverSide: true,
                ajax: "{{ route('perm_fuel_page_fetch') }}",
                columns: [{
                        data: 'counter',
                        name: 'counter'
                    },
                    {
                        data: 'vehicle',
                        name: 'vehicle'
                    },
                    {
                        data: 'month',
                        name: 'month'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '.view-btn', function() {
                    // Get the request ID from the data attribute
                var selectedCarId = $(this).data('id');

                // Perform the Ajax request to fetch data based on the selected car ID
                $.ajax({
                    url: '/show_detail/' + selectedCarId,
                    type: 'get',
                    data: { id: selectedCarId },
                    success: function(response) {
                        $('#staticaccept').modal('show');

                        // Clear previous cards and image preview
                        var cardsContainer = $('#inspectionCardsContainer');
                        cardsContainer.empty(); 
                        clearFilePreview(); 

                        if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                            // Populate the table and info section
                            var table = $('<table class="table table-striped">').append(`
                                <thead>
                                    <tr>
                                        <th>Roll no</th>
                                        <th>Fuel Amount</th>
                                        <th>Fuel Cost</th>
                                        <th>Fueling Date</th>
                                        <th>Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            `);

                            var count = 0;
                            response.data.forEach(function(fueling) {
                                count++;
                                var row = $(`
                                    <tr>
                                        <td>${count}</td>
                                        <td>${fueling.fuel_amount}</td>
                                        <td>${fueling.fuel_cost}</td>
                                        <td>${fueling.fuiling_date}</td>
                                        <td>
                                            <a href="javascript:void(0);" onclick="showFileInIframe('{{ asset('storage/vehicles/reciept/') }}/${fueling.reciet_attachment}')">
                                                ${fueling.reciet_attachment}
                                            </a>
                                        </td>
                                    </tr>
                                `);
                                table.find('tbody').append(row);
                            });

                            cardsContainer.append(table);
                        } else {
                            cardsContainer.html('<p>No inspection data available.</p>');
                        }
                    },
                    error: function() {
                        var cardsContainer = $('#inspectionCardsContainer');
                        cardsContainer.html('<p>No inspection data available at the moment. Please check the Plate number!</p>');
                    }
                });
            });

            function showFileInIframe(fileUrl) {
                clearFilePreview(); 
                var filePreview = document.getElementById('filePreview');
                filePreview.src = fileUrl; // Set the file URL to the iframe's src
                filePreview.style.display = 'block'; // Display the iframe
            }

            function clearFilePreview() {
                var filePreview = document.getElementById('filePreview');
                filePreview.src = ''; // Clear the src to "erase" the previous image
                filePreview.style.display = 'none'; // Optionally hide the iframe
            }

            $(document).ready(function() {
            $(document).on('click', '.reject-btn', function() {
                AcceptedId = $(this).data('id');

                $('#request_id').val(AcceptedId);
                $('#confirmationModal').modal('show');
                });
        });

        </script>
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
    @endsection
