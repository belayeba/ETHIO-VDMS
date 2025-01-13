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
                                            <th>#</th>
                                            <th>Requested By</th>
                                            <th>Vehicle Type</th>
                                            <th>Requested At</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
                                            <div class="modal-body">
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-5">Request reason</dt>
                                                    <dd class="col-sm-7" data-field="purpose"></dd>

                                                    <dt class="col-sm-5">Requested vehicle</dt>
                                                    <dd class="col-sm-7" data-field="vehicle_type"></dd>

                                                    <dt class="col-sm-5">Start date and Time</dt>
                                                    <dd class="col-sm-7" data-field="start_date"></dd>

                                                    <dt class="col-sm-5">Return date and Time</dt>
                                                    <dd class="col-sm-7" data-field="end_date"></dd>

                                                    <dt class="col-sm-5">Location From and To</dt>
                                                    <dd class="col-sm-7" data-field="start_location"></dd>

                                                    <dt class="col-sm-5">Passengers</dt>
                                                    <dd class="col-sm-7" data-field="passengers"></dd>

                                                    <dt class="col-sm-5">Materials</dt>
                                                    <dd class="col-sm-7" data-field="materials"></dd>

                                                    <dt class="col-sm-5">Progress</dt>
                                                    <dd class="col-sm-7" data-field="progress"></dd>
                                                </dl>
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
                                                        <h4 class="mt-2">Warning</h4>
                                                        <h5 class="mt-3">
                                                            Are you sure you want to accept this request?</br> This action
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

                                <!-- this is for the assign  modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="staticBackdropLabel">Maintenance Return
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div> <!-- end modal header -->
                                           
                                                <div class="modal-body">
                                                    <form id="maintenance-form" method="POST" action="{{route('end_maintenance')}}">
                                                        @csrf
                                                    
                                                         <input type="hidden" name="maintenance_id" id="maintenance_id" class="form-control" required>
                                                       
                                                        <!-- Maintenance Records -->
                                                        <div id="maintenance-records-container">
                                                            <h4>Records</h4>
                                                            <div class="maintenance-record row align-items-center g-3">

                                                                <div class="col-md-3">
                                                                    <label>Maintenance Start Date</label>
                                                                    <input type="date" name="maintenance_records[0][maintenance_start_date]" class="form-control" required>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Maintenance End Date</label>
                                                                    <input type="date" name="maintenance_records[0][maintenance_end_date]" class="form-control" required>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Completed Task</label>
                                                                    <input type="text" name="maintenance_records[0][completed_task]" class="form-control" required>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Maintained By</label>
                                                                    <input type="text" name="maintenance_records[0][maintained_by]" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="add-maintenance-record" class="btn btn-primary">Add</button>

                                                       
                                                        <!-- Items for Next Maintenance -->
                                                        <div id="items-next-maintenance-container"> </br>
                                                            <h4>Items for Next Maintenance</h4>
                                                            <div class="next-maintenance-item row align-items-center g-3">
                                                                <div class="col-md-3">
                                                                    <label>Part Type</label>
                                                                    <input type="text" name="items_for_next_maintenance[0][part_type]" class="form-control">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Measurement</label>
                                                                    <input type="text" name="items_for_next_maintenance[0][measurment]" class="form-control">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Quantity</label>
                                                                    <input type="number" name="items_for_next_maintenance[0][quantity]" class="form-control">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Part Number</label>
                                                                    <input type="text" name="items_for_next_maintenance[0][part_no]" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="add-next-maintenance-item" class="btn btn-primary">Add</button>

                                                        <!-- Maintenance Costs -->
                                                        <div id="maintenance-costs-container"></br>
                                                            <h4>Maintenance Costs</h4>
                                                            <div class="maintenance-cost row align-items-center g-3">
                                                                <div class="col-md-3">
                                                                    <label>Spare Part Cost</label>
                                                                    <input type="number" name="total_maintenance_cost[0][sparepart_cost]" class="form-control" min="0">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Machine Cost</label>
                                                                    <input type="number" name="total_maintenance_cost[0][machine_cost]" class="form-control" min="0">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Labor Cost</label>
                                                                    <input type="number" name="total_maintenance_cost[0][labor_cost]" class="form-control" min="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="add-maintenance-cost" class="btn btn-primary">Add</button>

                                                        <!-- Nezek -->
                                                        <div id="nezek-container"></br>
                                                            <h4>Nezek</h4>
                                                            <div class="nezek row align-items-center g-3">
                                                                <div class="col-md-3">
                                                                    <label>Amount of Nezek</label>
                                                                    <input type="number" name="amount_of_nezek[0][amount_of_nezek]" class="form-control" min="0">
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label>Type of Nezek</label>
                                                                    <input type="text" name="amount_of_nezek[0][type_of_nezek]" class="form-control">
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="add-nezek" class="btn btn-primary">Add</button>


                                                         <!-- Replaced items -->
                                                         <div id="replaced-container"></br>
                                                            <h4>Spare Part used</h4>
                                                            <div class="spare row align-items-center g-3">
                                                                <div class="col-md-3">
                                                                    <label>Spare part</label>
                                                                    <input type="text" name="spareparts_used[0][spareparts_used]" class="form-control">
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="add-spare" class="btn btn-primary">Add</button>


                                                        <!-- Technician Description -->
                                                        <div></br>
                                                            <label for="technician_description">Technician Description</label>
                                                            <div class="form-floating col-md-6">
                                                                <textarea class="form-control" name="technician_description" rows="6"  style="resize: none;" required></textarea>
                                                                {{-- <label for="floatingTextarea">Comment</label> --}}
                                                            </div>
                                                        </div> 
                                                    <script>
                                                        // Add Maintenance Record
                                                        let maintenanceRecordIndex = 1;
                                                        document.getElementById('add-maintenance-record').addEventListener('click', function () {
                                                            const container = document.getElementById('maintenance-records-container');
                                                            const newRecord = `
                                                                <div class="maintenance-record row align-items-center g-3">
                                                                    <div class="col-md-3">
                                                                    <label>Maintenance Start Date</label>
                                                                    <input type="date" name="maintenance_records[${maintenanceRecordIndex}][maintenance_start_date]" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                    <label>Maintenance End Date</label>
                                                                    <input type="date" name="maintenance_records[${maintenanceRecordIndex}][maintenance_end_date]" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                    <label>Completed Task</label>
                                                                    <input type="text" name="maintenance_records[${maintenanceRecordIndex}][completed_task]" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                    <label>Maintained By</label>
                                                                    <input type="text" name="maintenance_records[${maintenanceRecordIndex}][maintained_by]" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-1 text-end mt-2">
                                                                        <button type="button" class="btn btn-danger remove-maintenance-record">Remove</button>
                                                                    </div>
                                                                </div></br>
                                                            `;
                                                            container.insertAdjacentHTML('beforeend', newRecord);
                                                            maintenanceRecordIndex++;
                                                        });

                                                       
                                                        document.getElementById('maintenance-records-container').addEventListener('click', function (e) {
                                                            if (e.target.classList.contains('remove-maintenance-record')) {
                                                                const record = e.target.closest('.maintenance-record');
                                                                record.remove();
                                                            }
                                                        });
                                                    
                                                        // Add Item for Next Maintenance
                                                        let nextMaintenanceIndex = 1;
                                                        document.getElementById('add-next-maintenance-item').addEventListener('click', function () {
                                                            const container = document.getElementById('items-next-maintenance-container');
                                                            const newItem = `
                                                                <div class="next-maintenance-item row align-items-center g-3">
                                                                    <div class="col-md-3">
                                                                    <label>Part Type</label>
                                                                    <input type="text" name="items_for_next_maintenance[${nextMaintenanceIndex}][part_type]" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                    <label>Measurement</label>
                                                                    <input type="text" name="items_for_next_maintenance[${nextMaintenanceIndex}][measurment]" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                    <label>Quantity</label>
                                                                    <input type="number" name="items_for_next_maintenance[${nextMaintenanceIndex}][quantity]" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                    <label>Part Number</label>
                                                                    <input type="text" name="items_for_next_maintenance[${nextMaintenanceIndex}][part_no]" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-1 text-end mt-2">
                                                                        <button type="button" class="btn btn-danger remove-next_maintenance">Remove</button>
                                                                    </div>
                                                                </div>
                                                            `;
                                                            container.insertAdjacentHTML('beforeend', newItem);
                                                            nextMaintenanceIndex++;
                                                        });

                                                        document.getElementById('items-next-maintenance-container').addEventListener('click', function (e) {
                                                            if (e.target.classList.contains('remove-next_maintenance')) {
                                                                const record = e.target.closest('.next-maintenance-item');
                                                                record.remove();
                                                            }
                                                        });

                                                        let maintenanceCostIndex = 1;
                                                        document.getElementById('add-maintenance-cost').addEventListener('click', function () {
                                                            const container = document.getElementById('maintenance-costs-container');
                                                            const newCost = `
                                                                <div class="maintenance-cost row align-items-center g-3">
                                                                    <div class="col-md-3">
                                                                    <label>Spare Part Cost</label>
                                                                    <input type="number" name="total_maintenance_cost[${maintenanceCostIndex}][sparepart_cost]" class="form-control" min="0">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                    <label>Machine Cost</label>
                                                                    <input type="number" name="total_maintenance_cost[${maintenanceCostIndex}][machine_cost]" class="form-control" min="0">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                    <label>Labor Cost</label>
                                                                    <input type="number" name="total_maintenance_cost[${maintenanceCostIndex}][labor_cost]" class="form-control" min="0">
                                                                    </div>

                                                                    <div class="col-md-1 text-end mt-2">
                                                                        <button type="button" class="btn btn-danger remove-total_maintenance">Remove</button>
                                                                    </div>
                                                                </div>
                                                            `;
                                                            container.insertAdjacentHTML('beforeend', newCost);
                                                            maintenanceCostIndex++;
                                                        });

                                                        document.getElementById('maintenance-costs-container').addEventListener('click', function (e) {
                                                            if (e.target.classList.contains('remove-total_maintenance')) {
                                                                const record = e.target.closest('.maintenance-cost');
                                                                record.remove();
                                                            }
                                                        });

                                                        let nezekIndex = 1;
                                                        document.getElementById('add-nezek').addEventListener('click', function () {
                                                            const container = document.getElementById('nezek-container');
                                                            const newNezek = `
                                                                <div class="nezek row align-items-center g-3">
                                                                    <div class="col-md-3">
                                                                    <label>Amount of Nezek</label>
                                                                    <input type="number" name="amount_of_nezek[${nezekIndex}][amount_of_nezek]" class="form-control" min="0">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                    <label>Type of Nezek</label>
                                                                    <input type="text" name="amount_of_nezek[${nezekIndex}][type_of_nezek]" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-1 text-end mt-2">
                                                                        <button type="button" class="btn btn-danger remove-amount_of_nezek">Remove</button>
                                                                    </div>
                                                                </div>
                                                            `;
                                                            container.insertAdjacentHTML('beforeend', newNezek);
                                                            nezekIndex++;
                                                        });

                                                        document.getElementById('nezek-container').addEventListener('click', function (e) {
                                                            if (e.target.classList.contains('remove-amount_of_nezek')) {
                                                                const record = e.target.closest('.nezek');
                                                                record.remove();
                                                            }
                                                        });

                                                        let spareIndex = 1;
                                                        document.getElementById('add-spare').addEventListener('click', function () {
                                                            const container = document.getElementById('replaced-container');
                                                            const newSpare = `
                                                                <div class="spare col-md-3">

                                                                    <div class="col-md-3">
                                                                    <label>Spare part</label>
                                                                    <input type="text" name="spareparts_used[${spareIndex}][spareparts_used]" class="form-control">
                                                                    </div>

                                                                    <div class="col-md-1 text-end mt-2">
                                                                        <button type="button" class="btn btn-danger remove-amount_of_spare">Remove</button>
                                                                    </div>
                                                                </div>
                                                            `;
                                                            container.insertAdjacentHTML('beforeend', newSpare);
                                                            spareIndex++;
                                                        });

                                                        document.getElementById('replaced-container').addEventListener('click', function (e) {
                                                            if (e.target.classList.contains('remove-amount_of_spare')) {
                                                                const record = e.target.closest('.spare');
                                                                record.remove();
                                                            }
                                                        });

                                                    </script>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
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
                        d.customDataValue = 5;
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

            $(document).on('click', '.accept-btn', function() {
                AcceptedId = $(this).data('id');

                $('#request_id').val(AcceptedId);
                $('#confirmationModal').modal('show');
            });
        });

        $(document).ready(function() {
            var MaintenanceId;

            $(document).on('click', '.reject-btn', function() {
                MaintenanceId = $(this).data('id');

                $('#maintenance_id').val(MaintenanceId);
                $('#staticBackdrop').modal('toggle');
            });
        });
    </script>

   <!-- App js -->
   <script src="{{ asset('assets/js/app.min.js') }}"></script>
   @endsection
   <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
