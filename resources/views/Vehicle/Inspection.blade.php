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
        <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Vehicle Inspection</h4>
                    </div>
                    <div class="card-body"> 
                        <form method="POST" action="{{route('inspection.store')}}">
                            @csrf

                            <div id="progressbarwizard">
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                    <li class="nav-item">
                                        <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class=" ri-list-check-3 fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Inspection Form</span>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class="ri-timer-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Duration</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class=" ri-map-pin-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Location</span>
                                        </a>
                                    </li> -->
                                </ul>

                                <div class="tab-content b-0 mb-0">

                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                                </div>
                            
                                <div class="tab-pane" id="account-2">
                                <div class="row">
                                    <div class="position-relative mb-3">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Select Vehicle</label>
                                            <select class="form-control" id="department_id" name="vehicle_id">
                                                <option value="">Select Vehicle</option>
                                                    @foreach ($vehicle as $vec )
                                                    <option value="{{$vec->vehicle_id}}">
                                                        {{$vec->plate_number}}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div> 
                                    </div>
                                    @foreach($parts as $part)
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <strong>{{$part->name}}</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input ok-checkbox" id="ok_{{$loop->index}}" name="damaged_parts[{{$part->id}}]" value="1" data-row="{{$loop->index}}">
                                                            <input type="hidden" name="parts[{{$part->id}}]" value="{{$part->vehicle_parts_id}}">
                                                            <label class="form-check-label" for="ok_{{$loop->index}}">OK</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                    <div class="form-check form-checkbox-danger">
                                                        <input type="checkbox" class="form-check-input damaged-checkbox" id="damaged_{{$loop->index}}" name="damaged_parts[{{$part->id}}]" value="0" data-row="{{$loop->index}}">
                                                        <label class="form-check-label" for="damaged_{{$loop->index}}">Damaged</label>
                                                        <input type="text" name="damage_descriptions[{{$part->id}}]" class=" d-none damaged-notes" placeholder="Add Description" data-row="{{$loop->index}}">
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                    <ul class="list-inline wizard mb-0">
                                        <!-- <li class="next list-inline-item float-end">
                                            <a href="javascript:void(0);" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></a>
                                        </li> -->
                                        <li class="next list-inline-item float-end">
                                            <button type="submit" class="btn btn-info">Submit<i class="ri-arrow-right-line ms-1"></i></button>
                                        </li>
                                    </ul>
                                </div> 

                                <div class="tab-pane" id="profile-tab-2">
                                  
                                        <ul class="pager wizard mb-0 list-inline">
                                            <li class="previous list-inline-item">
                                                <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                            </li>
                                            <li class="next list-inline-item float-end">
                                                <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                            </li>
                                        </ul>
                                </div> 
                                
                                <div class="tab-pane" id="finish-2">
                                <ul class="pager wizard mb-0 list-inline">
                                            <li class="previous list-inline-item">
                                                <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                            </li>
                                            <li class="next list-inline-item float-end">
                                                <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                            </li>
                                        </ul>
                                    </div> 
                                </div>   
                            </div>

                        </form> 

                    </div> <!-- end card-->
             </div> <!-- end col-->
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Roll.no</th>
                                <th>Plate number</th>
                                <th>Inspection Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @foreach($inspections as $data) 
                        <tbody>
                            <tr>
                                <td>{{$data->inspection_id}}</td>
                                <td>{{$data->vehicle->plate_number}}</td>
                                <td>{{$data->inspection_date}}</td>
                                <td> <input type="hidden" value="{{$data->inspection_id}}" id="vehicleselection">
                                    <a href="#" class="btn btn-info rounded-pill"  id="assignBtn" title="Inspect">Inspect</a></td>

                            </tr>
                        </tbody>
                    @endforeach
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
    </div><!-- end col-->
</div> 

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- Datatables js -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    

    <!-- Datatable Demo Aapp js -->
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection