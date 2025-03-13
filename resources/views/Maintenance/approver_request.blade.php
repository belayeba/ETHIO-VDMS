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
            <!-- <h4 class="header-title mb-4">DIRECTOR PAGE</h4> -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive" id="table1">
                                <table class="table director_datatable table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.Roll No.') }}</th>
                                            <th>{{ __('messages.Requested By') }}</th>
                                            <th>{{ __('messages.Vehicle') }}</th>
                                            <th>{{ __('messages.Maintenance Type') }}</th>
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
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('messages.Request Details')</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <dl class="row mb-0">
                                                    <input type="hidden" id="vehicleselection" >
                                                    <dt class="col-sm-5">Maintenance Purpose</dt>
                                                    <dd class="col-sm-7"><span id="purpose"></span></dd>

                                                    <dt class="col-sm-5">@lang('messages.Current Mileage')</dt>
                                                    <dd class="col-sm-7"><span id="millage"></span></dd>


                                                    <dt class="col-sm-5">Current Inspection</dt>
                                                    <dd class="col-sm-7"> <button  type="button" class="btn btn-primary "  id="assignBtn"  title="Inspect">Check</button></dd>

                                                </dl>
                                                <div class="table-responsive">
                                                    <div class="row mt-3" id="inspectionCardsContainer" class="table table-striped"> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end show modal -->

                                <!-- Accept Alert Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('approver_approve_request') }}">
                                                @csrf
                                                <input type="hidden" name="maintenance_id" id="request_id">
                                                <input type="hidden" name="maintenance_status" value="approved">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i class="ri-alert-line h1 text-warning"></i>
                                                        <h4 class="mt-2">@lang('messages.Warning')</h4>
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

                                <!-- this is for the assign  modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">@lang('messages.Reject reason')
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div> <!-- end modal header -->
                                            <form method="POST" action="{{ route('approver_rejection') }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-lg-6">
                                                        <h5 class="mb-3"></h5>
                                                        <div class="form-floating">
                                                            <input type="hidden" name="maintenance_id" id="Reject_request_id">
                                                            <input type="hidden" name="maintenance_status" value="rejected">

                                                            <textarea class="form-control" name="approver_rejection_reason" style="height: 60px;" required></textarea>
                                                            <label for="floatingTextarea">@lang('messages.Reason')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">@lang('messages.Close')</button>
                                                    <button type="submit" class="btn btn-danger">@lang('messages.Reject')</button>
                                                </div> <!-- end modal footer -->
                                            </form>
                                        </div> <!-- end modal content-->
                                    </div> <!-- end modal dialog-->
                                </div>
                                <!-- end assign modal -->

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


    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        var table = $('.director_datatable').DataTable({
            processing: true,
            pageLength: 5,
            serverSide: true,
            ajax: {
                    url: "{{ route('FetchMaintenanceRequest') }}",
                    data: function (d) {
                        d.customDataValue = 2;
                    }
                },    
                columns: [{
                        data: 'counter',
                        name: 'counter'
                    },
                    {
                        data: 'requestedBy',
                        name: 'requestedBy'
                    },
                    {
                        data: 'vehicle',
                        name: 'vehicle'
                    },
                    {
                        data: 'type',
                        name: 'type'
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
                var AcceptedId;

                $(document).on('click', '.show-btn', function() {
                    AcceptedId = $(this).data('id');
                    car = $(this).data('vehicleid');
                    millage = $(this).data('millage');
                    reason = $(this).data('reason');
                    inspection = $(this).data('inspection');
                // console.log(car);

                    $('#request_id').val(AcceptedId);
                    $('#vehicleselection').val(car);
                    $('#millage').text(millage);
                    $('#purpose').text(reason);
                    $('#inspection').text(inspection);
                    $('#standard-modal').modal('show');
                });
            });

        document.getElementById('assignBtn').addEventListener('click', function() {
           
           var selectedCarId = document.getElementById('vehicleselection').value;
           console.log(selectedCarId);
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

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.accept-btn', function() {
                AcceptedId = $(this).data('id');

                $('#request_id').val(AcceptedId);
                $('#confirmationModal').modal('show');
            });
        });

        $(document).ready(function() {
            var RejectedId;

            $(document).on('click', '.reject-btn', function() {
                RejectedId = $(this).data('id');

                $('#Reject_request_id').val(RejectedId);
                $('#staticBackdrop').modal('toggle');
            });
        });
    </script>

   <!-- App js -->
   <script src="{{ asset('assets/js/app.min.js') }}"></script>
   @endsection
   <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
