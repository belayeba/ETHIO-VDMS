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
                <div class="row g-3">
                    <!-- Form Section -->
                    <div class="col-12 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Letter Request</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('letter.store') }}" id="letter_request_form" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div id="progressbarwizard">
                                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                            <li class="nav-item">
                                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Request</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content b-0 mb-0">
                                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                                <div
                                                    class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="account-2">
                                                <div class="row">

                                                    <div class="position-relative mb-3">
                                                        <div class="mb-6 position-relative" >
                                                            <label class="form-label">Upload Letter</label>
                                                            <input type="file" name="letter_file" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>

                                                <ul class="list-inline wizard mb-0">
                                                    <li class="next list-inline-item float-end">
                                                        <button type="submit" id="letter_request_form_submit" class="btn btn-info">Submit</button>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('letter_request_form').addEventListener('submit', function() {
                                            let button = document.getElementById('letter_request_form_submit');
                                            button.disabled = true;
                                            button.innerText = "Processing..."; // Optional: Change text to indicate processing
                                        });
                                    </script>
                                </form>

                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table attendance_datatable table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Prepared By</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Warning Alert Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('attendance.destroy') }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="request_id" id="Reject_attendance_id">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i class="ri-alert-line h1 text-warning"></i>
                                                        <h4 class="mt-2">Warning</h4>
                                                        <h5 class="mt-3">
                                                            Are you sure you want to delete this item? This action cannot be
                                                            undone.
                                                        </h5>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger"
                                                            id="confirmDelete">Yes,
                                                            Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                 <!-- show all the information about the request modal -->
                                    <div id="standard-modal-view" class="modal fade" tabindex="-1" role="dialog"
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
                                                        <dt class="col-sm-5">Reviewed By</dt>
                                                        <dd class="col-sm-7" id="review_view"></dd>
                                                    
                                                        <dt class="col-sm-5">Approved By</dt>
                                                        <dd class="col-sm-7" id="approved_view"></dd>
                                                    
                                                        <dt class="col-sm-5">Sent to Department</dt>
                                                        <dd class="col-sm-7" id="department_view"></dd>

                                                        <dt class="col-sm-5">Accepted By</dt>
                                                        <dd class="col-sm-7" id="accepted_view"></dd>
                                                    
                                                        <dt class="col-sm-5">Document</dt>
                                                        <dd class="col-sm-7"><a href="" id="image">Click to View</a></dd>
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

                                <!-- show all the information about the request modal -->
                                <div id="update-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Request Update
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form  method="post" id="update-form" enctype="multipart/form-data">
                                                    @csrf
                                                        <div class="row">
                                                            <div class="position-relative mb-3">
                                                                <label class="form-label">Attendance</label>
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <div class="form-check">
                                                                            <input type="hidden" name="morning" value="0">
                                                                            <input type="checkbox" class="form-check-input ok-checkbox" name="morning" id="morning" value="1" data-row="">
                                                                            <label class="form-check-label" for="yes_">Morning</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <div class="form-check">
                                                                            <input type="hidden" name="afternoon" value="0">
        
                                                                            <input type="checkbox" class="form-check-input damaged-checkbox" name="afternoon" id="afternoon" value="1" data-row="">
                                                                            
                                                                            <label class="form-check-label" for="no_">Night</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>  

                                                            <input type="hidden" name="notes" id="request_update_id">

                                                            <div class="position-relative mb-3">
                                                                <div class="mb-6 position-relative" >
                                                                    <label class="form-label">Remark</label>
                                                                    <input type="text" name="notes" class="form-control" id="notes" placeholder="Enter Remark if any">
                                                                </div>
                                                            </div>
        
                                                        </div>
                                                    </div>                                                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- end show modal -->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                </div>
            </div>

            


    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        var table = $('.attendance_datatable').DataTable({
            processing: true,
            pageLength: 5,
            serverSide: true,
            ajax: "{{ route('FetchLetter') }}",
            columns: [{
                    data: 'counter',
                    name: 'counter'
                },
                {
                    data: 'preparedBy',
                    name: 'preparedBy'
                },
                {
                    data: 'date',
                    name: 'date'
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
           

            $(document).on('click', '.view-btn', function() {
         
                reviewedBy = $(this).data('reviewedby') || 'Pending';
                approvedBy = $(this).data('approvedby') || 'Pending';
                department = $(this).data('department') || 'Not Assigned';
                acceptedBy = $(this).data('letter_acceptor') || 'Pending';
                pdfFile = $(this).data('image');
                storagePath = "{{ asset('storage/Letters') }}" +'/'+ pdfFile;
            
                // pdfFile = $(this).data('pdf');
                // storagePath = 'storage/app/public/Letters/' + pdfFile;
                // console.log(pdfFile);

             
                
                
                $('#review_view').text(reviewedBy);
                $('#approved_view').text(approvedBy);
                $('#department_view').text(department);
                $('#accepted_view').text(acceptedBy);
                $('#image').html('<a href="' + storagePath + '" target="_blank">Open PDF</a>');


                $('#standard-modal-view').modal('show');
            });
        });

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.update-btn', function() {
                AcceptedId = $(this).data('id');
                morning = $(this).data('morning');
                night = $(this).data('afternoon');
                notes = $(this).data('notes');

                $('#update-form').attr('action', '{{ route('attendance.update', ['id' => ':id']) }}'.replace(':id', AcceptedId));

                $('#request_update_id').val(AcceptedId);
                $('#morning').prop('checked', morning == 1);
                $('#afternoon').prop('checked', night == 1);
                $('#notes').val(notes);
                $('#update-modal').modal('show');
            });
        });

        $(document).ready(function() {
            var RejectedId;

            $(document).on('click', '.reject-btn', function() {
                RejectedId = $(this).data('id');

                $('#Reject_attendance_id').val(RejectedId);
                $('#confirmationModal').modal('toggle');
            });
        });
    </script>

   <!-- App js -->
   <script src="{{ asset('assets/js/app.min.js') }}"></script>
   @endsection
   <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
