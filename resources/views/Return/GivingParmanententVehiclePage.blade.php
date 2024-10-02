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
                                        <form method="POST" action="{{ route('user_perm_delet') }}">
                                            @csrf
                                            <input type="hidden" name="request_id" value="{{ $request->vehicle_request_permanent_id }}">
                                            <button type="button" class="btn btn-info rounded-pill" title="show"><i class=" ri-eye-line"></i></button>
                                            @if($request->status === 1 )
                                            <a href="{{route('perm_vec_update')}}" class="btn btn-secondary rounded-pill"  data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="edit"><i class=" ri-edit-line"></i>return</a>
                                            {{-- <button type="submit" class="btn btn-danger rounded-pill" title="Delete"><i class="ri-close-circle-line"></i></button> --}}
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
</div>
</div>
                                
                    
 <!-- Dropzone File Upload js -->
 <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

<!-- File Upload Demo js -->
<script src="{{ asset('assets/js/pages/fileupload.init.js') }}"></script>
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
@endsection