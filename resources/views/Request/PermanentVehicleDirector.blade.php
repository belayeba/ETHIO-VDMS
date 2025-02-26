@extends('layouts.navigation')
@section('content')

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
                <!-- <h4 class="header-title mb-4">DIRECTOR PAGE</h4> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive"  id="table1">
                                        <div class="dropdown btn-group">
                                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownButton">
                                                ALL
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-animated">
                                                <a class="dropdown-item" onclick="updateState(1, 'PENDING')">PENDING</a>
                                                <a class="dropdown-item" onclick="updateState(2, 'ASSIGNED')">ASSIGNED</a>
                                                <a class="dropdown-item" onclick="updateState(3, 'TAKEN')">TAKEN</a>
                                                <a class="dropdown-item" onclick="updateState(4, 'REJECTED')">REJECTED</a>
                                            </div>
                                        </div></br></br>
                                        <table class="table dispatcher_datatable table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('messages.Roll No.') }}</th>
                                                    <th>{{ __('messages.Requested By') }}</th>
                                                    <th>{{ __('messages.Reason') }}</th>
                                                    <th>{{ __('messages.Date') }}</th>
                                                    <th>{{ __('messages.Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>   
                                        </table>
                                    </div>
                                    <!-- end .table-responsive-->
                                    
                                    
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content --> 
           
             <!-- show all the information about the request modal -->
                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Request Details</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-6">
                                    <dl class="row mb-1">
                                        <dt class="col-sm-5">@lang('messages.position')</dt>
                                        <dd class="col-sm-7" id="ShowPosition"></dd>
                                    </dl>

                                    <dl class="row mb-1">
                                        <dt class="col-sm-5">@lang('messages.Request reason')</dt>
                                        <dd class="col-sm-7" id="reason"></dd>
                                    </dl>
                                </div></br></br>
                                <div class="row">
                                    <!-- Left Card -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title">@lang('messages.Position Letter')</h5>
                                            </div>
                                            <div class="card-body">
                                            <iframe id="image1" class="img-fluid" style="width: 100%; height: 100%;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!-- Right Card -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title">@lang('messages.Driving License')</h5>
                                            </div>
                                            <div class="card-body">
                                                <iframe id="image2" src="" alt="Driving License" class="img-fluid"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('messages.Close')</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- end show modal -->

             <!-- this is for the reject  modal -->
                <div class="modal fade" id="staticreject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Reject reason</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div> <!-- end modal header -->
                            <form method="POST" action="{{route('perm_vec_simirit_reject')}}">
                                @csrf
                                <div class="modal-body">
                                    <div class="col-lg-6">
                                        <h5 class="mb-3"></h5>
                                        <div class="form-floating">
                                        <input type="hidden" name="request_id" id="reject_request_id">
                                        <textarea class="form-control" name="reason" style="height: 60px;" required></textarea>
                                        <label for="floatingTextarea">@lang('messages.Reason')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('messages.Close')</button>
                                    <button type="submit" class="btn btn-danger">@lang('messages.Reject')</button>
                                </div> <!-- end modal footer -->
                            </form>                                                                    
                        </div> <!-- end modal content-->
                    </div> <!-- end modal dialog-->
                </div>
            <!-- end reject modal -->

             <!-- this is for the assign  modal -->
                <div class="modal fade" id="staticaccept" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">                                   
                        <div class="modal-content">
                            <form method="POST" action="{{route('perm_vec_simirit_approve')}}">
                                @csrf   
                                <div class="modal-header">
                                        <div class="col-lg-6">
                                            <h5 class="mb-0">@lang('messages.Select Vehicle')</h5>
                                                <select name="vehicle_id" class="form-select" id="vehicleselection"  required>
                                                    <option value="" selected>Select</option>
                                                    @foreach ($Vehicle as $item)
                                                        <option value="{{$item->vehicle_id}}">{{$item->plate_number}}</option>
                                                    @endforeach
                                                </select>
                                            <input type="hidden" name="request_id" id="request_id">
                                        </div>                                                               
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div> <!-- end modal header -->
                                <div class="modal-body">@lang('messages.Select a Vehicle and check Inspection, Before assigning.')
                                    <div class="table-responsive">
                                        <div class="row mt-3" id="inspectionCardsContainer" class="table table-striped"> 
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"  id="assignBtn">@lang('messages.Get Inspection')</button>
                                    <button type="submit" class="btn btn-primary">@lang('messages.Assign')</button>
                                </div> <!-- end modal footer -->
                            </form>                                                                    
                        </div> <!-- end modal content-->
                    </div> <!-- end modal dialog-->
                </div>

    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>


    <script>
         let customDataValue = 0;

         function updateState(value, buttonText) {
            document.getElementById('dropdownButton').innerText = buttonText;
            customDataValue = value; 
            table.ajax.reload();
        }

        var table = $('.dispatcher_datatable').DataTable({
            processing: true,
            pageLength: 5,
            serverSide: true,
            ajax: 
                {
                    url: "{{ route('FetchPermanentForDispatcher') }}",
                    data: function (d) 
                        {
                            d.customDataValue = customDataValue;
                        }
                },         
            columns: [{
                    data: 'counter',
                    name: 'counter'
                },
                {
                    data: 'requested_by',
                    name: 'requested_by'
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
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(document).ready(function() {
            var RejectedId;

            $(document).on('click', '.show-btn', function() {
                Reason = $(this).data('reason');
                Position = $(this).data('position');
                PositionLetter = $(this).data('position_letter');
                DrivingLicense = $(this).data('driving_license');

                // Construct file paths for the iframes
                const positionLetterPath = '/storage/PermanentVehicle/PositionLetter/' + PositionLetter;
                const drivingLicensePath = '/storage/PermanentVehicle/Driving_license/' + DrivingLicense;

                // Populate the iframes with the file paths
                $('#reason').text(Reason);
                $('#ShowPosition').text(Position);
                $('#image1').attr('src', positionLetterPath);
                $('#image2').attr('src', drivingLicensePath);
       
                $('#standard-modal').modal('toggle');
            });
        });

        $(document).ready(function() {
            var RejectedId;

            $(document).on('click', '.reject-btn', function() {
                RejectedId = $(this).data('id');

                $('#reject_request_id').val(RejectedId);
                $('#staticreject').modal('toggle');
            });
        });

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.accept-btn', function() {
                AcceptedId = $(this).data('id');

                $('#request_id').val(AcceptedId);
                $('#staticaccept').modal('show');
            });
        });

        document.getElementById('assignBtn').addEventListener('click', function() {
           
           var selectedCarId = document.getElementById('vehicleselection').value;

           // Perform an Ajax request to fetch data based on the selected car ID
           $.ajax({
               url: "{{ route('inspection.ByVehicle') }}",
               type: 'GET',
               data: { id: selectedCarId },
               success: function(response) {
                          // $('#showinspection-modal').modal('show');
                           var cardsContainer = document.getElementById('inspectionCardsContainer');
                           cardsContainer.innerHTML = ''; // Clear previous cards

                           if (response.status === 'success' && Array.isArray(response.data) && response.data
                               .length > 0) {
                               // Create the table
                               var Image = response.data[0].image_path;
                               var imageUrl = Image ? "{{ asset('storage/vehicles/Inspections/') }}" + '/' + Image : null;
                               var inspectedBy = response.data[0].inspected_by;
                               var createdAt = new Date(response.data[0].created_at).toLocaleDateString(
                                   'en-US', {
                                       year: 'numeric',
                                       month: '2-digit',
                                       day: '2-digit'
                                   });
                               // Create a section to display "Inspected By" and "Created At" at the top right corner
                               var infoSection = document.createElement('div');
                               infoSection.className = 'd-flex justify-content-end mb-4'; // Flexbox to align right and add margin-bottom
                               infoSection.innerHTML = `
                                   <p><strong>Inspected By:</strong> ${inspectedBy} </br>
                                   <strong>Created At:</strong> ${createdAt}</br>
                                   <strong>Image:</strong> 
                                   ${ imageUrl 
                                       ? `<a href="${imageUrl}" target="_blank"> Click to View </a>` 
                                       : 'No image'
                                   }
                               `;
                               cardsContainer.appendChild(
                                   infoSection); // Append the info section before the table
                               var h1 = document.createElement('h4');
                               h1.style.textAlign = 'center';
                               h1.innerHTML = 'Vehilce parts';
                               var h2 = document.createElement('h4');
                               h2.style.textAlign = 'center';
                               h2.innerHTML = 'Spare parts';
                               var table = document.createElement('table');
                               table.className = 'table table-striped'; // Add Bootstrap classes for styling
                               table.innerHTML = `
                               <thead>
                                   <tr>
                                       <th>Vehicle Part</th>
                                       <th>Is Damaged</th>
                                       <th>Damage Description</th>
                                   </tr>
                               </thead>
                               <tbody>
                               </tbody>
                           `;

                                   response.data.forEach(function(inspection) {
                                       if(inspection.type == "normal_part")
                                        {
                                           var row = document.createElement('tr');
                                           row.innerHTML = `
                                           <td>${inspection.part_name}</td>
                                           <td>${inspection.is_damaged ? 'No' : 'Yes'}</td>
                                           <td>${inspection.damage_description ? inspection.damage_description : '-'}</td>
                                           `;
                                           table.querySelector('tbody').appendChild(
                                               row); // Append row to the table body
                                       }
                               });
                               cardsContainer.appendChild(h1);
                               cardsContainer.appendChild(table);
                               // Spare Part
                               var table = document.createElement('table');
                               table.className = 'table table-striped'; // Add Bootstrap classes for styling
                               table.innerHTML = `
                                       <thead>
                                           <tr>
                                               <th>Spare Part</th>
                                               <th>Is Available</th>
                                               <th>Quantity</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                       </tbody>
                                   `;

                               response.data.forEach(function(inspection) 
                               {
                                   if(inspection.type == "spare_part")
                                       {
                                           var row = document.createElement('tr');
                                           row.innerHTML = `
                                           <td>${inspection.part_name}</td>
                                           <td>${inspection.is_damaged == "0"? 'No' : 'Yes'}</td>
                                           <td>${inspection.damage_description ? inspection.damage_description : '-'}</td>
                                           `;
                                               table.querySelector('tbody').appendChild(
                                                   row); // Append row to the table body
                                       }
                               });
                               cardsContainer.appendChild(h2);
                               cardsContainer.appendChild(table);

                           } 
                           else 
                           {
                               // Handle the case where no data is available
                               cardsContainer.innerHTML = '<p>No inspection data available.</p>';
                           }
                       },
                       error: function() {
                           $('#showinspection-modal').modal('show');
                           var cardsContainer = document.getElementById('inspectionCardsContainer');
                           cardsContainer.innerHTML = ''; // Clear previous cards
                           cardsContainer.innerHTML =
                               '<p>No inspection data available at the moment. Please check the Plate number!</p>';
                       }
           });
       });
                                                  
</script>
  <!-- App js -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  @endsection
  <script src="{{ asset('assets/js/vendor.min.js') }}"></script>