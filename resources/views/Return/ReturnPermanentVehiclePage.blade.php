@extends('layouts.navigation')
@section('content')

{{--  --}}

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
                <div class="row g-3">
                    <!-- Form Section -->
                    <div class="col-12 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Return Permanent Vehicle</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('return_vehicle_permanent')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div id="progressbarwizard">
                                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                            <li class="nav-item">
                                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                                    class="nav-link rounded-0 py-2">
                                                    <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                                    <span class="d-none d-sm-inline">Return Request</span>
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
                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                            <label class="form-label">Reason</label>
                                                            <input type="text" name="purpose" class="form-control"
                                                                placeholder="Enter purpose of Request">
                                                        </div>
                                                    </div>

                                                    <div class="position-relative mb-3">
                                                        <label class="form-label">Select Vehicle</label>
                                                        <select class="form-select" name="request_id"
                                                            aria-label="Floating label select example">
                                                            <option selected>Vehicles</option>
                                                            @foreach($Requested->where('director_reject_reason', null)->where('vec_director_reject_reason', null) as $request)
                                                            <option value="{{$request->vehicle_request_permanent_id}}">{{$request->vehicle->plate_number}}</option>
                                                            @endforeach
                                                        </select>
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

                    <div class="col-12 col-lg-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Roll.no</th>
                                                <th>Date Requested</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       
                                            @foreach($Return as $request)
                                            <tbody>
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$request->created_at->format('Y-m-j')}}</td>
                                                    <td>{{$request->returned_date == null ? 'Pending' : 'Returned'}}</td>
                                                    <td>
                                                        <form method="POST" action="">
                                                            @csrf
                                                            <input type="hidden" name="request_id" value="{{ $request->vehicle_request_permanent_id }}">
                                                            @if($request->reject_reason_vec_director !== null || $request->reject_reason_dispatcher !== null )
                                                            <a href="{{route('perm_vec_update')}}" class="btn btn-primary rounded-pill"  data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="Return">return</a>
                                                            @endif
                                                            <button type="submit" class="btn btn-danger rounded-pill" title="Delete"><i class="ri-close-circle-line"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                
                                            <!-- show all the information about the request modal -->
                                            <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Return Request</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{route('return_vehicle_permanent')}}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                            <div class="tab-pane" id="account-2">
                                                                                <div class="row">
                                                                                    <div class="position-relative mb-3">
                                                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                                                            <label class="form-label">Reason</label>
                                                                                            <input type="text" name="purpose" class="form-control" placeholder="Enter purpose of Request">
                                                                                        </div>
                                                                                    </div>
                                            
                                                                                    <div class="position-relative mb-3">
                                                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                                                            <label class="form-label">Vehicle</label>
                                                                                            <select class="form-select" name="vehicle"
                                                                                            aria-label="Floating label select example">
                                                                                            <option selected>Vehicles</option>
                                                                                            @foreach($Requested->where('director_reject_reason', null)->where('vec_director_reject_reason', null) as $request)
                                                                                            <option value="{{$request->vehicle->vehicle_id}}">{{$request->vehicle->plate_number}}</option>
                                                                                            @endforeach
                                                                                        </select>                                            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                            
                                                                                <ul class="list-inline wizard mb-0">
                                                                                    <li class="next list-inline-item float-end">
                                                                                        <button type="submit" class="btn btn-info">Submit</button>
                                                                                    </li>
                                                                                </ul>
                                            
                                                                            </div>  
                                                                    </div>
                                                                </form>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>
                                            <!-- end show modal -->
                                        @endforeach                            
                                    </table>
                                 </div>
                              </div> <!-- end card body-->
                            </div> <!-- end card -->
                         </div><!-- end col-->
                     </div>
                 </div>
             </div>

        <!-- Start Content-->
{{-- <div class="container-fluid">
    <div class="row">
       

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Roll.no</th>
                                <th>Date Requested</th>
                                <th>Date Given</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($Requested->where('director_reject_reason', null)->where('vec_director_reject_reason', null) as $request)
                            <tbody>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$request->created_at->format('Y-m-j')}}</td>
                                    <td>{{$request->given_date}}</td>
                                    <td>{{$request->status == 1 ? 'Owned' : 'Returned'}}</td>
                                    <td>
                                        <form method="POST" action="">
                                            @csrf
                                            <input type="hidden" name="request_id" value="{{ $request->vehicle_request_permanent_id }}">
                                            @if($request->status === 1 )
                                            <a href="{{route('perm_vec_update')}}" class="btn btn-primary rounded-pill"  data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="Return">return</a>
                                            @endif
                                            <button type="submit" class="btn btn-danger rounded-pill" title="Delete"><i class="ri-close-circle-line"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>

                            <!-- show all the information about the request modal -->
                            <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Return Request</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('return_vehicle_permanent')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                            <div class="tab-pane" id="account-2">
                                                                <div class="row">
                                                                    <div class="position-relative mb-3">
                                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                                            <label class="form-label">Reason</label>
                                                                            <input type="text" name="purpose" class="form-control" placeholder="Enter purpose of Request">
                                                                        </div>
                                                                    </div>
                            
                                                                    <div class="position-relative mb-3">
                                                                        <div class="mb-6 position-relative" id="datepicker1">
                                                                            <label class="form-label">Vehicle</label>
                                                                            <select class="form-select" name="vehicle"
                                                                            aria-label="Floating label select example">
                                                                            <option selected>Vehicles</option>
                                                                            @foreach($Requested->where('director_reject_reason', null)->where('vec_director_reject_reason', null) as $request)
                                                                            <option value="{{$request->vehicle->vehicle_id}}">{{$request->vehicle->plate_number}}</option>
                                                                            @endforeach
                                                                        </select>                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                            
                                                                <ul class="list-inline wizard mb-0">
                                                                    <li class="next list-inline-item float-end">
                                                                        <button type="submit" class="btn btn-info">Submit</button>
                                                                    </li>
                                                                </ul>
                            
                                                            </div>  
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
</div> --}}
{{-- </div> --}}
                                
                    
 <!-- Dropzone File Upload js -->
 <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

<!-- File Upload Demo js -->
<script src="{{ asset('assets/js/pages/fileupload.init.js') }}"></script>
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
@endsection