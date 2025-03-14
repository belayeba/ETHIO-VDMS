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
                                            <select name="vehicle_id" id = "vehicle_id" class="form-select mb-3">
                                                <option selected>Open this select menu</option>
                                                    @foreach($vehicles as $vehicle)
                                                        <option value="{{$vehicle->vehicle_id}}">{{$vehicle->vehicle->plate_number}}</option>
                                                    @endforeach
                                            </select> 
                                        @endif
                                    </div>

                                    <div>
                                        <label>Year</label>
                                        <input name="year" id="year" type="number" placeholder="Enter year (2010 - 2050)" class="form-control mb-3" min="2010" max="2050"/>
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Select Month</label>
                                        <select class="form-select mb-3" name="month" id="month">
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
                                    <div id = "hidden_div" hidden>
                                        <h4 id="display_cost">Yea Displayed</h4>
                                    </div>
                                    <!-- Entries Container -->
                                    <div id="entriesContainer"></div>
                                    
                                    <!-- Buttons: Add and Submit (aligned to the right) -->
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" id="addItem" class="btn btn-primary rounded-pill">Attach Reciet</button>
                                        <button type="submit" id="fuelForm_submit" class="btn btn-info ms-3">Submit</button>
                                    </div>

                                    <script>
                                        document.getElementById('fuelForm').addEventListener('submit', function() {
                                                let button = document.getElementById('fuelForm_submit');
                                                button.disabled = true;
                                                button.innerText = "Processing..."; 
                                            });
                                    </script>
                                </form>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const addButton = document.getElementById('addItem');
                                        const entriesContainer = document.getElementById('entriesContainer');
                                        let entryCount = 0;
                                        const csrfToken = "{{ csrf_token() }}";
                                        // Add button event listener
                                        addButton.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            // Get values from the form
                                            
                                            var year = document.getElementById('year').value;
                                            var month = document.getElementById('month').value;
                                            var vehicle_id = document.getElementById('vehicle_id').value;
                                            // Validate inputs (optional)
                                            if (!year || !month) 
                                            {
                                                alert('Please select both year and month.');
                                                return;
                                            }
                                           // Send data to the backend using AJAX
                                           $.ajax({
                                                    url: '/get_each_cost',
                                                    type: 'POST',
                                                    data: { year: year,month:month,vehicle_id:vehicle_id, _token: csrfToken },
                                                    
                                                    success: function(response) {

                                                        // Handle success
                                                        if (response.status === 'success') {
                                                        const index = entryCount++;
                                                        const entryDiv = document.createElement('div');
                                                        const hiddenDiv = document.getElementById('hidden_div');
                                                        const h1_of_display_cost = document.getElementById('display_cost');
                                                        //expected_cost.innerHTML = response.data.expected_total;
                                                        entryDiv.classList.add('entry', 'mt-3');
                                                        
                                                        entryDiv.innerHTML = `
                                                            <div class="row">
                                                                
                                                                <div class="col-md-4">
                                                                    <label>Price</label>
                                                                    <input name="fuel_cost[${index}]" class="form-control" placeholder="In Birr" type="number" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Date</label>
                                                                    <input name="fuiling_date[${index}]" class="form-control" placeholder="When" type="date" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Attachment</label>
                                                                    <input name="reciet_attachment [${index}]" class="form-control" type="file" required>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-danger btn-sm removeEntry">x</button>
                                                                </div>
                                                            </div>
                                                        `;
                                                        
                                                        // Append new entry to the container
                                                        // if(entryCount == 1) 
                                                        //   {
                                                        //     entriesContainer.appendChild(expected_cost);
                                                        //   }
                                                        hiddenDiv.innerHTML = "<h4>Expected total Fuel Cost in ETB : " +response.data.expected_total+ "</h4>";
                                                        hiddenDiv.removeAttribute("hidden");
                                                        entriesContainer.appendChild(entryDiv);
                                                        } else {
                                                            alert(response.message);
                                                        }
                                                    },
                                                    error: function() {
                                                        var cardsContainer = $('#inspectionCardsContainer');
                                                        cardsContainer.html('<p>No inspection data available at the moment. Please check the Plate number!</p>');
                                                    }
                                                });                              
                                        });
                                        //Event delegation for delete buttons (remove entry)
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
                                                <th scope="col">Month</th>
                                                <th scope="col">Approved Cost</th>
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
                pageLength: 5,
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
                        data: 'approved_cost',
                        name: 'approved_cost'
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
                            var total_fuel =  response.total_fuel;
                            var h2 = $('<h4>').append('Expected Fuel Cost in ETB : <span style="text-decoration: underline;font-size:16px;">'+response.expected_fuel+ '</span>');
                            var h1 = $('<h4>').append('Attached Total cost in ETB: <span style="text-decoration: underline;font-size:16px;">' + total_fuel + '</span>');
                            var input = $('<div id="entriesInputContainer"></div>')
                            var attach = $(` <div class="row"><div class="col-2"> <button class="btn btn-info btn-sm attach-btn" style="position: absolute; right: 10px; top: 10px;" data-id="${selectedCarId}">Attach New Reciet</button></div>`);
                            var table = $('<table class="table table-striped">').append(`
                                
                                <thead>
                                    <tr>
                                        <th>Roll no</th>
                                        <th>Fuel Cost</th>
                                        <th>Fueling Date</th>
                                        <th>Receipt</th>
                                        <th></th>
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
                                        <td>${fueling.fuel_cost}</td>
                                        <td>${fueling.fuiling_date}</td>
                                        <td>
                                            <a href="javascript:void(0);" onclick="showFileInIframe('{{ asset('storage/vehicles/reciept/') }}/${fueling.reciet_attachment}')">
                                                Click to View
                                            </a>
                                        </td>
                                        <td>
                                           ${fueling.accepted == 0 && fueling.final_approved == null ? `
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <button class="btn btn-primary btn-sm update-btn" data-row="${fueling.primary}" data-cost="${fueling.fuel_cost}" data-date="${fueling.fuiling_date}">Update</button>                                                        </div>
                                                    </div>
                                                </div>
                                            ` : ''} 
                                        </td>
                                    </tr>
                                `);
                                table.find('tbody').append(row);
                          
                                cardsContainer.append(h2);
                                
                                if (fueling.final_approved == null) {
                                        cardsContainer.append(attach);
                                    }
                            });
                            cardsContainer.append(table);
                            cardsContainer.append(h1);
                            cardsContainer.append(input);
                            
                        } else {
                            cardsContainer.html('<p>No  data available.</p>');
                        }
                    },
                    error: function() {
                        var cardsContainer = $('#inspectionCardsContainer');
                        cardsContainer.html('<p>No data available at the moment!</p>');
                    }
                });
            });

            $(document).on('click', '.attach-btn', function () {
                var rowId = $(this).data('id');
                console.log(rowId);
        
                const entriesInputContainer = document.getElementById('entriesInputContainer');

                const entryDiv = document.createElement('div');

                entryDiv.classList.add('entry', 'mt-3');
                entryDiv.id = `entry-${rowId}`;
                                                        
                entryDiv.innerHTML = `
                    <div class="row">
                        
                        <div class="col-md-4">
                            <label>Price</label>
                            <input name="fuel_cost" class="form-control" placeholder="In Birr" type="number"  required>
                        </div>
                        <div class="col-md-4">
                            <label>Date</label>
                            <input name="fuiling_date" class="form-control" placeholder="When" type="date"  required>
                        </div>
                        <div class="col-md-4">
                            <label>Attachment</label>
                            <input name="reciet_attachment" class="form-control" type="file" required>
                        </div>
                        <div class="col-md-2">
                             <button type="button" class="btn btn-info btn-sm submitAttached-btn" data-row="${rowId}">+</button>
                            <button type="button" class="btn btn-danger btn-sm removeInputEntry">x</button>
                        </div>
                    </div>
                `;
                
                
                entriesInputContainer.appendChild(entryDiv);

            });

            $(document).on('click', '.submitAttached-btn', function () {
                    var rowId = $(this).data('row'); // Assuming `data-row` attribute is set on the button
                    const parentRow = $(this).closest('.row'); // Get the parent row container
                    // Retrieve input values
                    const fuelCost = parentRow.find('input[name="fuel_cost"]').val();
                    const fuelingDate = parentRow.find('input[name="fuiling_date"]').val();
                    const receiptInput = parentRow.find('input[name="reciet_attachment"]'); 
                    const csrfToken = "{{ csrf_token() }}";

                    const receiptAttachment = receiptInput[0].files[0];
                    
                    if (!fuelCost || !fuelingDate || !receiptAttachment) {
                        alert('Please fill all the fields and attach a receipt.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('_token', csrfToken); 
                    formData.append('id', rowId); 
                    formData.append('fuel_cost', fuelCost);
                    formData.append('fuiling_date', fuelingDate);
                    formData.append('reciet_attachment', receiptAttachment);
                  

                    // AJAX request
                    $.ajax({
                    url: '/attach_new_reciet', 
                    type: 'POST',
                    data: formData,
                    processData: false, 
                    contentType: false, 
                    success: function (response) {
                        if (response.success === true) {
                            alert('Data submitted');
                            
                            parentRow.remove(); 
                        } else {
                            alert(response.message || 'An error occurred.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('Failed to submit data. Please try again.');
                    }
                });
            });


            $(document).on('click', '.update-btn', function () {
                var rowId = $(this).data('row');
                var rowCost = $(this).data('cost');
                var rowDate = $(this).data('date');
        
                const entriesInputContainer = document.getElementById('entriesInputContainer');

                if (document.getElementById(`entry-${rowId}`)) {
                    console.log(`Input fields for already exist.`);
                    return; 
                }

                const entryDiv = document.createElement('div');

                entryDiv.classList.add('entry', 'mt-3');
                entryDiv.id = `entry-${rowId}`;
                                                        
                entryDiv.innerHTML = `
                    <div class="row">
                        
                        <div class="col-md-4">
                            <label>Price</label>
                            <input name="fuel_cost" class="form-control" placeholder="In Birr" type="number" value="${rowCost}" required>
                        </div>
                        <div class="col-md-4">
                            <label>Date</label>
                            <input name="fuiling_date" class="form-control" placeholder="When" type="date" value="${rowDate}" required>
                        </div>
                        <div class="col-md-4">
                            <label>Attachment</label>
                            <input name="reciet_attachment" class="form-control" type="file" required>
                        </div>
                        <div class="col-md-2">
                             <button type="button" class="btn btn-primary btn-sm submitInput-btn" data-row="${rowId}"><i class="ri-checkbox-circle-line"></i></button>
                            <button type="button" class="btn btn-danger btn-sm removeInputEntry">x</button>
                        </div>
                    </div>
                `;
                
                
                entriesInputContainer.appendChild(entryDiv);

            });

            $(document).on('click', '.removeInputEntry', function () {
                $(this).closest('.entry').remove(); 
            });

            $(document).on('click', '.submitInput-btn', function () {
                    var rowId = $(this).data('row'); // Assuming `data-row` attribute is set on the button
                    const parentRow = $(this).closest('.row'); // Get the parent row container

                    // Retrieve input values
                    const fuelCost = parentRow.find('input[name="fuel_cost"]').val();
                    const fuelingDate = parentRow.find('input[name="fuiling_date"]').val();
                    const receiptInput = parentRow.find('input[name="reciet_attachment"]'); 
                    const csrfToken = "{{ csrf_token() }}";

                    const receiptAttachment = receiptInput[0].files[0];
                    
                    if (!fuelCost || !fuelingDate || !receiptAttachment) {
                        alert('Please fill all the fields and attach a receipt.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('_token', csrfToken); 
                    formData.append('make_primary', rowId); 
                    formData.append('fuel_cost', fuelCost);
                    formData.append('fuiling_date', fuelingDate);
                    formData.append('reciet_attachment', receiptAttachment);
                  

                    // AJAX request
                    $.ajax({
                    url: '/update_entries', 
                    type: 'POST',
                    data: formData,
                    processData: false, 
                    contentType: false, 
                    success: function (response) {
                        if (response.status === 'success') {
                            alert('Data submitted');
                            
                            parentRow.remove(); 
                        } else {
                            alert(response.message || 'An error occurred.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('Failed to submit data. Please try again.');
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
