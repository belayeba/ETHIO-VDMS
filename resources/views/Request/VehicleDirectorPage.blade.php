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
                                            <a class="dropdown-item" onclick="updateState(3, 'DISPATCHED')">DISPATCHED</a>
                                            <a class="dropdown-item" onclick="updateState(4, 'DISPATCHED')">RETURNED</a>
                                        </div>
                                    </div></br></br>

                                <table class="table dispatcher_datatable table-centered mb-0 table-nowrap" id="inline-editable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.Roll No.') }}</th>
                                            <th>{{ __('messages.Requested By') }}</th>
                                            <th>{{ __('messages.Vehicle Type')}}</th>
                                            <th>{{ __('messages.Requested At') }}</th>
                                            <th>{{ __('messages.Status') }}</th>
                                            <th>{{ __('messages.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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
                                                <div class="col-md-6">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-4">Field Letter:
                                                            </dt>
                                                            <dd class="col-sm-8" data-field="Fieldletter">
                                                            </dd>
                                                        </dl>
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-5">@lang('messages.Request reason')</dt>
                                                    <dd class="col-sm-7" data-field="purpose"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Requested vehicle')</dt>
                                                    <dd class="col-sm-7" data-field="vehicle_type"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Start date and Time')</dt>
                                                    <dd class="col-sm-7" data-field="start_date"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Return date and Time')</dt>
                                                    <dd class="col-sm-7" data-field="end_date"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Location From and To')</dt>
                                                    <dd class="col-sm-7" data-field="start_location"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Passengers')</dt>
                                                    <dd class="col-sm-7" data-field="passengers"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Materials')</dt>
                                                    <dd class="col-sm-7" data-field="materials"></dd>

                                                    <dt class="col-sm-5">@lang('messages.Progress')</dt>
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
                        </div>
                            <!-- this is for the assign  modal -->
                            <div class="modal fade" id="staticaccept" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">                                   
                                     <div class="modal-content">
                                        <form method="POST" action="{{route('simirit_approve_temporary')}}">
                                            @csrf   
                                            <div class="modal-header">
                                                    <div class="col-lg-6">
                                                        <h5 class="mb-0">@lang('messages.Select Vehicle')</h5>
                                                            <select name="assigned_vehicle_id" class="form-select" id="vehicleselection"  required>
                                                                <option value="" selected>Select</option>
                                                                    <optgroup label="None Occupied Vehicles">
                                                                        @foreach ($vehicles as $item)
                                                                            <option value="{{$item->vehicle_id}}">{{$item->plate_number}}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                    
                                                                    <optgroup label="Occupied Vehicles">
                                                                        @foreach ($AssignedVehicles as $item)
                                                                            <option value="{{$item->vehicle_id}}">{{$item->plate_number}}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                            </select>
                                                        <input type="hidden" name="request_id" id="request_id">
                                                    </div>                                                               
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div> <!-- end modal header -->
                                            <div class="modal-body">
                                                {{-- <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="package" value="1">
                                                    <label class="form-check-label" style="font-size: 16px">Assign A New Vehicle</label>
                                                </div></br></br> --}}
                                                <div>
                                                    @lang('messages.Select a Vehicle and check Inspection, Before assigning.')
                                                    <div class="table-responsive">
                                                        <div class="row mt-3" id="inspectionCardsContainer" class="table table-striped"> 
                                                        </div>
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
                             
                            <!-- this is for the reject  modal -->
                            <div class="modal fade" id="staticreject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Reject request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div> <!-- end modal header -->
                                        <form method="POST" action="{{route('simirit_reject')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="col-lg-6">
                                                    <h5 class="mb-3"></h5>
                                                    <div class="form-floating">
                                                    <input type="hidden" name="request_id" id="reject_id" >
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

                            {{-- dispatch modal for the request --}}
                            <div class="modal fade" id="staticdispatch" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="staticBackdropLabel">@lang('messages.Assigned Vehicle')</h4>&nbsp;&nbsp;
                                            <h3  class="text-info"><span id="Display_plate_accepted"></span></h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div> <!-- end modal header -->
                                        <form method="POST" action="{{route('simirit_fill_start_km')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-6 position-relative">
                                                    <label class="form-label">@lang('messages.Start KM')</label>
                                                    <input type="number" class="form-control" name="start_km"
                                                        placeholder="Enter Initial KM">
                                                </div>
                                                <input type="hidden" name="request_id" id="dispatch_id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                <button type="submit" class="btn btn-primary">@lang('messages.Dispatch')</button>
                                            </div> <!-- end modal footer -->
                                        </form>                                                                    
                                    </div> <!-- end modal content-->
                                </div> <!-- end modal dialog-->
                            </div>
                            {{-- end dispatch modal --}}

                             {{-- return modal for the request --}}
                            <div class="modal fade" id="staticreturn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="staticBackdropLabel">@lang('messages.Assigned Vehicle')</h4>&nbsp;&nbsp;
                                            <h3  class="text-info"><span id="Display_plate"></span></h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div> <!-- end modal header -->
                                        <form method="POST" action="{{route('simirit_return_vehicle')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-6 position-relative">
                                                    <label class="form-label">@lang('messages.End KM')</label>
                                                    <input type="number" class="form-control" name="end_km"
                                                        placeholder="Enter Return KM">
                                                </div>
                                                <input type="hidden" name="request_id" id="return_id">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                <button type="submit" class="btn btn-warning">@lang('messages.Return')</button>
                                            </div> <!-- end modal footer -->
                                        </form>                                                                    
                                    </div> <!-- end modal content-->
                                </div> <!-- end modal dialog-->
                            </div>
                            {{-- end return modal --}}

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
                    url: "{{ route('FetchForDispatcher') }}",
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
                    data: 'vehicle_type',
                    name: 'vehicle_type'
                },
                {
                    data: 'date',
                    name: 'date'
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
                                        <th>Avaialable</th>
                                        <th>Description</th>
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
                                            <td>${inspection.is_damaged ? 'Yes' : 'No'}</td>
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
        
        $('#standard-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modal = $(this); // The modal
            var letterFile = $(this).data('field_letter');

            var letterField = modal.find('[data-field="Fieldletter"]');
            if (letterFile) 
                    {
                        var fieldLink = `<a href="app/public/TemporaryVehicle/FieldLetters/${letterFile}" target="_blank">View Letter</a>`;
                        letterField.html(fieldLink);
                    } 
                else 
                    {
                        letterField.text('No file available');
                    }
            //   Populate basic request details
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
                    passengerList += person.user.first_name + ' ' + person.user.middle_name  + '<br>';
                });
            }
            modal.find('[data-field="passengers"]').html(passengerList);

            // Populate materials
            var materials = button.data('materials');
            var materialList = '';
            if (materials) {
                materials.forEach(function(material) {
                    materialList +=  material.material_name + ' ' + material.weight + '.<br>';
                });
            }
            modal.find('[data-field="materials"]').html(materialList);

            // Function to build progress messages
            function buildProgressMessage(button) {
                let progressMessages = [];

                const messages = [
                    {
                        condition: button.data('dir_approved_by') && !button.data('director_reject_reason'),
                        message: '<span style="color: green;">'+ button.data('dir_approved_by')+' (Director)'+'</span>'
                    },
                    {
                        condition: button.data('director_reject_reason') && button.data('dir_approved_by'),
                        message: '<span style="color: red;">Rejected By '+ button.data('dir_approved_by')+'(Director)</span>'
                    },
                    {
                        condition: button.data('div_approved_by') && !button.data('cluster_director_reject_reason'),
                        message: '<span style="color: green;">' + button.data('div_approved_by') + ' (Division)' +  '</span>'
                    },
                    {
                        condition: button.data('cluster_director_reject_reason') && button.data('div_approved_by'),
                        message: '<span style="color: red;">Rejected by ' +button.data('div_approved_by') +' (Division)' +  '</span>'
                    },
                    {
                        condition: button.data('hr_div_approved_by') && !button.data('hr_director_reject_reason'),
                        message: '<span style="color: green;">' + button.data('hr_div_approved_by') + ' (Division)</span>'
                    },
                    {
                        condition: button.data('hr_director_reject_reason') && button.data('hr_div_approved_by'),
                        message: '<span style="color: red;">Rejected by '+ button.data('hr_div_approved_by') + ' ( Division)</span>'
                    },
                    {
                        condition: button.data('transport_director_id') && !button.data('vec_director_reject_reason'),
                        message: '<span style="color: green;">'+button.data('transport_director_id')+' (Transport_Dir)</span>',
                    },
                    {
                        condition: button.data('vec_director_reject_reason') && button.data('transport_director_id'),
                        message: '<span style="color: red;">Rejected by '+button.data('transport_director_id')+' ( Transport_Dir)</span>',
                    },
                    {
                        condition: button.data('assigned_by') && !button.data('assigned_by_reject_reason'),
                        message: '<span style="color: green;">'+ button.data('assigned_by') +' (Dispatcher)</span>'
                    },
                    {
                        condition: button.data('assigned_by_reject_reason') && button.data('assigned_by'),
                        message: '<span style="color: red;">Rejected by '+ button.data('assigned_by') + ' (Dispatcher)</span>'
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

        $(document).ready(function() {
           // var AcceptedId;

            $(document).on('click', '.accept-btn', function() {
                var AcceptedId = $(this).data('id');
                //alert(AcceptedId);
                $('#request_id').val(AcceptedId);
                $('#staticaccept').modal('show');
            });
        });

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.dispatch-btn', function() {
                AcceptedId = $(this).data('id');
                aceeptedPlate = $(this).data('plate')
                // console.log(AcceptedId);

                $('#dispatch_id').val(AcceptedId);
                $('#Display_plate_accepted').text(aceeptedPlate);
                $('#staticdispatch').modal('show');
            });
        });

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.return-btn', function() {
                returnId = $(this).data('id');
                returnPlate = $(this).data('plate');
                // console.log(returnId, returnPlate);

                $('#return_id').val(returnId);
                $('#Display_plate').text(returnPlate);
                $('#staticreturn').modal('show');
            });
        });

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.reject-btn', function() {
                RejectedId = $(this).data('id');

                $('#reject_id').val(RejectedId);
                $('#staticreject').modal('show');
            });
        });
</script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

