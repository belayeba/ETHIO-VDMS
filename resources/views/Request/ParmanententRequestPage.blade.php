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

        <!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Request Permanent Vehicle</h4>
                </div>
                <div class="card-body"> 
                    <form action="{{route('vec_perm_request_post')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div id="progressbarwizard">
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                <li class="nav-item">
                                    <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                        <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Request</span>
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
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Reason</label>
                                                <input type="text" name="purpose" class="form-control" placeholder="Enter purpose of Request">
                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                                 <label class="form-label">Upload Position Latter</label>
                                                <input name="position_letter" class="form-control" type="file" >
                                        </div>

                                        <div class="position-relative mb-3">
                                                 <label class="form-label">Upload Driving License</label>
                                                <input name="Driving_license" class="form-control" type="file" >
                                        </div>
                                    </div>

                                    <ul class="list-inline wizard mb-0">
                                        <li class="next list-inline-item float-end">
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </li>
                                    </ul>

                                </div> 
                            </div>  
                        </div>

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
                                <th>Roll.no</th>
                                <th>Date Requested</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @foreach($Requested as $request)
                            <tbody>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$request->created_at->format('M j, Y,')}}</td>
                                    <td>{{$request->status}}</td>
                                    <td>
                                        <form method="POST" action="{{ route('user_perm_delet') }}">
                                            @csrf
                                            <input type="hidden" name="request_id" value="{{ $request->vehicle_request_permanent_id }}">
                                            <button type="button" class="btn btn-info rounded-pill" title="show"><i class=" ri-eye-line"></i></button>
                                            @if($request->approved_by === Null && $request->director_reject_reason === Null)
                                            <a href="{{route('perm_vec_update')}}" class="btn btn-secondary rounded-pill"  data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="edit"><i class=" ri-edit-line"></i></a>
                                            <button type="submit" class="btn btn-danger rounded-pill" title="Delete"><i class="ri-close-circle-line"></i></button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            </tbody>

                            <!-- show all the information about the request modal -->
                            <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Request Details</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="{{route('perm_vec_update')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                    
                                                
                                                        <div class="tab-pane" id="account-2">
                                                            <div class="row">
                                                                <div class="position-relative mb-3">
                                                                    <div class="mb-6 position-relative" id="datepicker1">
                                                                        <label class="form-label">Reason</label>
                                                                        <input type="text" name="purpose" value="{{$request->purpose}}" class="form-control" placeholder="Enter purpose of Request" required>
                                                                        <input type="hidden" name="request_id" value="{{$request->vehicle_request_permanent_id}}">
                                                                    </div>
                                                                </div>

                                                                <div class="position-relative mb-3">
                                                                        <label class="form-label">Upload Position Latter</label>
                                                                        <input name="position_letter" class="form-control" type="file" required>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-info">Submit</button>
                                                </div>
                                            </form>     
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            <!-- end show modal -->
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