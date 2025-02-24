{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> --}}

<!-- DataTables JS -->

@extends('layouts.navigation')

@section('content')
    <!-- DataTables CSS -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> --}}

    <!-- Content -->
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h4 class="header-title mb-0">@lang('messages.User Lists')</h4>
                                <div>
                                    <a href="{{ route('user_create') }}" class="btn btn-primary rounded-pill">@lang('messages.Create')</a>
                                    <button data-bs-toggle="modal" data-bs-target="#ImportModal" title="ImportUsers"  class="btn btn-warning rounded-pill">Import</button>
                                    <a href="{{ route('user_export') }}" class="btn btn-info rounded-pill">@lang('messages.Export')</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap user_datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">@lang('messages.Name')</th>
                                                <th scope="col">@lang('messages.Email')</th>
                                                <th scope="col">@lang('messages.Phone Number')</th>
                                                <th scope="col">@lang('messages.Department')</th>
                                                <th scope="col">@lang('messages.Start Date')</th>
                                                <th scope="col">@lang('messages.Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table content -->
                                        </tbody>
                                    </table>
                                      <!-- Accept Alert Modal -->
                                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                            aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('users.delete') }}">
                                                        @csrf
                                                        <input type="hidden" name="user_id" id="deleted_user_id">
                                                        <div class="modal-body p-4">
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">Warning</h4>
                                                                <h5 class="mt-3">
                                                                    Are you sure you want to DELETE this user?</br> This action
                                                                    cannot be
                                                                    undone.
                                                                </h5>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger"
                                                                    id="confirmDelete">Yes,
                                                                    DELETE</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                    <!-- /.modal -->

                                    <!-- Import Modal -->
                                    <div class="modal fade" id="ImportModal" tabindex="-1" role="dialog"
                                        aria-labelledby="ImportModalLabel"aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <form method="POST" id="importForm" action="{{ route('users.import') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body p-4">
                                                        <div class="text-center">
                                                            <h4 class="mt-2 text-warning" >Attention</h4>
                                                            <h5 class="mt-3">
                                                                Select an Excel file to import Users.
                                                            </h5>
                                                            <input type="file" class="form-control" name="file" required>
                                                        </div>
                                                    </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" id="importButton" class="btn btn-primary"
                                                                    >Import</button>
                                                        </div>
                                                        <script>
                                                            document.getElementById('importForm').addEventListener('submit', function() {
                                                                let button = document.getElementById('importButton');
                                                                button.disabled = true;
                                                                button.innerText = "Processing..."; // Optional: Change text to indicate processing
                                                            });
                                                        </script>
                                                </form>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                     <!-- /.modal -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row-->
      
    <!-- END wrapper -->

    <!-- jQuery first -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(function() {
            var table = $('.user_datatable').DataTable({

                pageLength: 5,
                ajax: "{{ route('users.list.show') }}",
                columns: [{
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'department_id',
                        name: 'department_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ]
            });
        });

        $(document).ready(function() {
            var RejectedId;

            $(document).on('click', '.reject-btn', function() {
                RejectedId = $(this).data('id');

                $('#deleted_user_id').val(RejectedId);
                $('#confirmationModal').modal('toggle');
            });
        });

    </script>

    <script>
        src = "{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" >
    </script>

    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
