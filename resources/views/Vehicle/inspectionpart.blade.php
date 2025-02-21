@extends('layouts.navigation')
@section('content')

<style>
    .badge {
        font-size: 0.9em;
        padding: 0.3em 0.5em;
        margin-right: 0.2em;
    }

    .remove-tag {
        cursor: pointer;
        margin-left: 0.3em;
    }
</style>

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

        <!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Add vehicle part for inspection</h4>
                </div>
                <div class="card-body"> 
                    <form action="{{route('vehicle_parts.store')}}" id="vehicle_part_form" method="post" enctype="multipart/form-data">
                        @csrf

                                <div id="progressbarwizard">
                                    <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                        <li class="nav-item">
                                            <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                                <i class="ri-settings-5-line fw-normal fs-20 align-middle me-1"></i>
                                                <span class="d-none d-sm-inline">@lang('messages.ADD')</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content b-0 mb-0">
                                        <div id="bar" class="progress mb-3" style="height: 7px;">
                                            <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                                        </div>

                                        <div class="tab-pane" id="account-2">
                                            <div class="row">
                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative">
                                                        <label class="form-label">@lang('messages.Type')</label>
                                                        <select name="type" class="form-control">
                                                            <option>Select Part Type</option>
                                                            <option value="spare_part">Spare Part</option>
                                                            <option value="normal_part">Vehicle Part</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative">
                                                        <label class="form-label">@lang('messages.Name')</label>
                                                        <input type="text" name="name" class="form-control" placeholder="Enter Name of vehicle part">

                                                    </div>
                                                </div>

                                                <div class="position-relative mb-3">
                                                    <div class="mb-6 position-relative">
                                                        <label class="form-label">@lang('messages.Notes')</label>
                                                        <input type="text" name="notes" class="form-control" placeholder="Enter notes for vehicle part">
                                                    </div>
                                                </div>

                                            </div>

                                    <ul class="list-inline wizard mb-0">
                                        <li class="next list-inline-item float-end">
                                            <button type="submit" class="btn btn-info" id="vehicle_part_form_submit">Submit</button>
                                        </li>
                                    </ul>

                                        </div>
                                    </div>
                                </div>

                        <script>
                            document.getElementById('vehicle_part_form').addEventListener('submit', function() {
                                let button = document.getElementById('vehicle_part_form_submit');
                                button.disabled = true;
                                button.innerText = "Processing..."; // Optional: Change text to indicate processing
                            });

                        </script>
                    </form> 

                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>

                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Roll No.') }}</th>
                                        <th>{{ __('messages.Part') }}</th>
                                        <th>{{ __('messages.Notes') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                </thead>
                                @foreach($vehicleParts as $request)
                                <tbody>
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$request->name}}</td>
                                        <td>{{$request->notes}}</td>
                                        <td>
                                            <a href="" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="edit"><i class=" ri-edit-line"></i></a>
                                            <!-- <button type="button" class="btn btn-danger rounded-pill reject-btn" data-bs-toggle="modal" data-bs-target="#confirmationModal-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button> -->
                                        </td>
                                    </tr>
                                </tbody>

                                <!-- edit the information of the request modal -->
                                <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Request Details</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('vehicle_parts.update',['id'=>$request->vehicle_parts_id])}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="tab-pane" id="account-2">
                                                        <div class="row">
                                                            <div class="position-relative mb-3">
                                                                <div class="mb-6 position-relative">
                                                                    <label class="form-label">@lang('messages.Type')</label>
                                                                    <select name="type" class="form-control">
                                                                        <option>Select Part Type</option>
                                                                        <option value="spare_part" {{ $request->type === 'spare_part' ? 'selected' : '' }}>Spare Part</option>
                                                                        <option value="norma_part" {{ $request->type !== 'spare_part' ? 'selected' : '' }}>Vehicle Part</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="position-relative mb-3">
                                                                <div class="mb-6 position-relative" id="datepicker1">
                                                                    <label class="form-label">@lang('messages.Name')</label>
                                                                    <input type="text" name="name" value="{{$request->name}}" class="form-control" placeholder="Enter purpose of Request" required>
                                                                    <input type="hidden" name="request_id" value="{{$request->vehicle_parts_id}}">
                                                                </div>
                                                            </div>

                                                            <div class="position-relative mb-3">
                                                                <label class="form-label">@lang('messages.Notes')</label>
                                                                <input type="text" name="notes" value="{{$request->notes}}" class="form-control" placeholder="Enter purpose of Request" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('messages.Close') }}</button>
                                                <button type="submit" class="btn btn-info">{{ __('messages.Submit') }}</button>
                                            </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- end show modal -->

                                <div class="modal fade" id="confirmationModal-{{ $loop->index }}" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('vehicle_parts.destroy', ['id' => $request->vehicle_parts_id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="request_id" id="request_id">
                                                <div class="modal-body p-4">
                                                    <div class="text-center">
                                                        <i class="ri-alert-line h1 text-danger"></i>
                                                        <h4 class="mt-2">Warning</h4>
                                                        <h5 class="mt-3">
                                                            Are you sure you want to DELETE this Inspection Form?</br> This action
                                                            cannot be
                                                            undone.
                                                        </h5>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">@lang('messages.Cancel')</button>
                                                        <button type="submit" class="btn btn-danger"
                                                            id="confirmDelete">Yes,
                                                            DELETE</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                @endforeach
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div>
    </div>


    <!-- Dropzone File Upload js -->
    <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

    <!-- File Upload Demo js -->
    <script src="{{ asset('assets/js/pages/fileupload.init.js') }}"></script>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    @endsection