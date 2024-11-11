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
                                        <select name="vehicle_id" class="form-select mb-3">
                                            <option selected>Open this select menu</option>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{$vehicle->vehicle_id}}">{{$vehicle->vehicle->plate_number}}</option>
                                            @endforeach
                                        </select>
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
                                    <table id="lms_table" class="table">
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
                                            @foreach($fuelings as $request)
                                            {{-- {{dd($fuelings)}} --}}
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->vehicle->plate_number}}</td>
                                                        <td>status</td>
                                                        <td>{{$request->month}}/{{$request->year}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill" title="Inspect" id="assignBtn-{{$loop->iteration}}">Show</button>
                                  
                                                            <input type="hidden" name="id" id="IdSelection-{{$loop->iteration}}" value="{{$request->fueling_id}}" id="vehicleselection">

                                                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>
                                                           
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <!-- this is for the assign  modal -->
                                                <div class="modal fade" id="staticaccept-{{$loop->iteration}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            
                                                                <div class="modal-header">
                                                                                                                                    
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div> <!-- end modal header -->
                                                                <div class="modal-body">
                                                                    <div class="row mt-3" id="inspectionCardsContainer-{{$loop->iteration}}" class="table table-striped"> 
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">close</button>
                                                                </div> <!-- end modal footer -->
                                                            </div>                                                              
                                                        </div> <!-- end modal content-->
                                                    </div> <!-- end modal dialog-->

                                                    
                                                    <script>
                                                        document.getElementById('assignBtn-{{$loop->iteration}}').addEventListener('click', function() {
                                                        var selectedCarId = document.getElementById('IdSelection-{{$loop->iteration}}').value;
                                                            
                                                            // Perform an Ajax request to fetch data based on the selected car ID
                                                            $.ajax({
                                                                url: '/show_detail/' + selectedCarId,
                                                                type: 'get',
                                                               
                                                                data: { id: selectedCarId },
                                                                success: function(response) {
                                                                    $('#staticaccept-{{$loop->iteration}}').modal('show');
                                                                    var cardsContainer = document.getElementById('inspectionCardsContainer-{{$loop->iteration}}');
                                                                    cardsContainer.innerHTML = ''; // Clear previous cards
                                                    
                                                                    if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                                                                        // Create the table
                                                                       
                                                                    // Create a section to display "Inspected By" and "Created At" at the top right corner
                                                                        var infoSection = document.createElement('div');
                                                                        infoSection.className = 'd-flex justify-content-end mb-4'; // Flexbox to align right and add margin-bottom
                                                                        infoSection.innerHTML = `
                                                                            <p><strong>Inspected By:</strong>  </br>
                                                                            <strong>Created At:</strong> </br>
                                                                        <strong>Image:</strong> 
                                                                       
                                                                        `;
                                                                        cardsContainer.appendChild(infoSection); // Append the info section before the table
                                                    
                                                                        var table = document.createElement('table');
                                                                        table.className = 'table table-striped'; // Add Bootstrap classes for styling
                                                                        table.innerHTML = `
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Roll no</th>
                                                                                    <th>Fuel Ammount</th>
                                                                                    <th>Fuel Cost</th>
                                                                                    <th>Fueling Date</th>
                                                                                    <th>Receit</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        `;
                                                                            
                                                                       var count = 0;
                                                                        response.data.forEach(function(fueling,index) {
                                                                            var row = document.createElement('tr');
                                                                             count = count +1;
                                                                            row.innerHTML = `
                                                                                <td>${count}</td>
                                                                                <td>${fueling.fuel_amount}</td>
                                                                                <td>${fueling.fuel_cost}</td>
                                                                                <td>${fueling.fuiling_date }</td>
                                                                                <td>${fueling.reciet_attachement }</td>
                                                                            `;
                                                                            table.querySelector('tbody').appendChild(row); // Append row to the table body
                                                                        });
                                                    
                                                                        cardsContainer.appendChild(table);
                                                    
                                                                    } else {
                                                                        // Handle the case where no data is available
                                                                        cardsContainer.innerHTML = '<p>No inspection data available.</p>';
                                                                    }
                                                                },
                                                                error: function() {
                                                                    var cardsContainer = document.getElementById('inspectionCardsContainer');
                                                                    cardsContainer.innerHTML = ''; // Clear previous cards
                                                                    cardsContainer.innerHTML = '<p>No inspection data available at the moment. Please check the Plate number!</p>';
                                                                }
                                                            });
                                                        });
                                                    </script>

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                    aria-labelledby="confirmDeleteLabel" aria-hidden="true">
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
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <a id="delete_link" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vendor js -->
                <script src="assets/js/vendor.min.js"></script>
                <!-- App js -->
                <script src="assets/js/app.min.js"></script>
            @endsection
