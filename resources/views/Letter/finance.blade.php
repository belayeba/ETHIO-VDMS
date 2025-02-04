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
                                <h4 class="header-title mb-4">REQUESTS</h4>

                                <table class="table director_datatable table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sent By</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

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
                                                        <!-- <dt class="col-sm-5">Reviewed By</dt>
                                                        <dd class="col-sm-7" id="review_view"></dd> -->
                                                    
                                                        <dt class="col-sm-5">Sent By</dt>
                                                        <dd class="col-sm-7" id="approved_view"></dd>
                                                    
                                                        <!-- <dt class="col-sm-5">Sent to Department</dt>
                                                        <dd class="col-sm-7" id="department_view"></dd> -->

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

                                <!-- Accept Alert Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form method="POST" id="accept-form">
                                                @csrf
                                                <input type="hidden" name="request_id" id="request_id">
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
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Reject reason
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div> <!-- end modal header -->
                                            <form method="POST" id="reject-form">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-lg-6">
                                                        <h5 class="mb-3"></h5>
                                                        <div class="form-floating">
                                                            <input type="hidden" name="request_id"
                                                                id="Reject_request_id">
                                                            <textarea class="form-control" name="approved_by_reject_reason" style="height: 60px;" required></textarea>
                                                            <label for="floatingTextarea">Reason</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Reject</button>
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
                    url: "{{ route('FetchForLetterRequest') }}",
                    data: function (d) {
                        d.customDataValue = 4;
                    }
                }, 
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
           

           $(document).on('click', '.view-btn', function() {
        
            //    reviewedBy = $(this).data('reviewedby') || 'Pending';
               approvedBy = $(this).data('approvedby') || 'Pending';
            //    department = $(this).data('department') || 'Not Assigned';
               acceptedBy = $(this).data('letter_acceptor') || 'Pending';
               pdfFile = $(this).data('image');
               storagePath = "{{ asset('storage/Letters') }}" +'/'+ pdfFile;
           
               // pdfFile = $(this).data('pdf');
               // storagePath = 'storage/app/public/Letters/' + pdfFile;
               //console.log(reviewedBy);

            
               
               
               //$('#review_view').text(reviewedBy);
               $('#approved_view').text(approvedBy);
               //$('#department_view').text(department);
               $('#accepted_view').text(acceptedBy);
               $('#image').html('<a href="' + storagePath + '" target="_blank">Open PDF</a>');


               $('#standard-modal-view').modal('show');
           });
       });

        $(document).ready(function() {
            var AcceptedId;

            $(document).on('click', '.accept-btn', function() {
                AcceptedId = $(this).data('id');

                $('#accept-form').attr('action', '{{ route('letter.accept', ['id' => ':id']) }}'.replace(':id', AcceptedId));

                $('#request_id').val(AcceptedId);
                $('#confirmationModal').modal('show');
            });
        });

        $(document).ready(function() {
            var RejectedId;

            $(document).on('click', '.reject-btn', function() {
                RejectedId = $(this).data('id');

                $('#reject-form').attr('action', '{{ route('letter.accept', ['id' => ':id']) }}'.replace(':id', RejectedId));

                $('#Reject_request_id').val(RejectedId);
                $('#staticBackdrop').modal('toggle');
            });
        });
    </script>

   <!-- App js -->
   <script src="{{ asset('assets/js/app.min.js') }}"></script>
   @endsection
   <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
