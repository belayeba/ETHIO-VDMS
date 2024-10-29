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
                    <h4 class="header-title">Add Fuel Quota</h4>
                </div>
                <div class="card-body"> 
                    <form action="{{ route('quota.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div id="progressbarwizard">
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                <li class="nav-item">
                                    <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                        <i class="ri-settings-5-line fw-normal fs-20 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">ADD</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0">
                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                                </div>
                        
                                <div class="tab-pane" id="account-2">
                                    <div class="row">
                                        
                                        <div class="col-mb-3 form-group {{ $errors->has('vehicle') ? 'has-error' : '' }}">
                                            <label for="vehicle" class=" control-label">Vehicle</label>
                                                
                                            <select class="form-control select" id="vehicleCategory" name="vehicle_id" data-fouc required>
                                                <option value="">Select Vehicle</option>
                                                @foreach ($vehicles as $vehicle)
                                                
                                                <option value="{{ $vehicle->vehicle_id }}">{{ $vehicle->plate_number }}</option>
                                            @endforeach
                                        </select>
                                                
                                                {!! $errors->first('vehicle', '<p class="help-block">:message</p>') !!}
                                            
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" >
                                                <label class="form-label">Fuel Quota</label>
                                                <input type="number" name="Fuel_Quota" class="form-control" placeholder="Enter fuel quota ">
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
                                <th>Vehicle</th>
                                <th>Old Quota</th>
                                <th>New Quota</th>
                                <th>Changed By</th>
                                <th>Changed Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                         @foreach($fuelQuatas as $fuelQuata)
                            <tbody>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$fuelQuata->vehicle->plate_number}}</td>
                                    <td>{{$fuelQuata->old_quata}}</td>
                                    <td>{{$fuelQuata->new_quata}}</td>
                                    <td>{{$fuelQuata->changer->first_name."  ".$fuelQuata->changer->last_name }}</td>
                                    <td>{{$fuelQuata->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('vehicle_parts.destroy', ['id' => $request->vehicle_parts_id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="edit"><i class=" ri-edit-line"></i></a>
                                            <button type="submit" class="btn btn-danger rounded-pill" title="Delete"><i class="ri-close-circle-line"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                            
                            <!-- edit the information of the request modal -->
                                {{-- <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
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
                                                            <div class="mb-6 position-relative" id="datepicker1">
                                                                <label class="form-label">Name</label>
                                                                <input type="text" name="name" value="{{$request->name}}" class="form-control" placeholder="Enter purpose of Request" required>
                                                                <input type="hidden" name="request_id" value="{{$request->vehicle_parts_id}}">
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mb-3">
                                                                <label class="form-label">Note</label>
                                                                <input type="text" name="notes" value="{{$request->notes}}" class="form-control" placeholder="Enter purpose of Request" required>
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
                            <!-- end show modal --> --}}

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