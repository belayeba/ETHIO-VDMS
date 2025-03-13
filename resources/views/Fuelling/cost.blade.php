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
                    <h4 class="header-title">@lang('messages.Add Fuel Cost')</h4>
                </div>
                <div class="card-body"> 
                    <form action="{{ route('save_cost_change')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div id="progressbarwizard">
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                <li class="nav-item">
                                    <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                        <i class="ri-settings-5-line fw-normal fs-20 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">@lang('messages.Add')</span>
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
                                            <div class="mb-6 position-relative" >
                                                <label class="form-label">@lang('messages.Cost of One Litre')</label>
                                                <input type="number" name="Fuel_cost" class="form-control" placeholder="Enter cost of 1 Litre Fuel ">
                                            </div>
                                        </div>
                                        <div class="col-mb-3 form-group {{ $errors->has('vehicle') ? 'has-error' : '' }}">
                                            <label for="vehicle" class=" control-label">@lang('messages.Fuel Type')</label>
                                                
                                            <select class="form-control select" id="vehicleCategory" name="fuel_type" data-fouc required>
                                                <option value="">Select Fuel Type</option>
                                                <option value="Benzene">Benzene</option>
                                                <option value="Diesel">Diesel</option>
                                            </select>

                                        </div>
                                    </div>

                                    <ul class="list-inline wizard mb-0">
                                        <li class="next list-inline-item float-end">
                                            <button type="submit" class="btn btn-info">@lang('messages.Submit')</button>
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
                                <th>{{ __('messages.Roll No.') }}</th>
                                <th>{{ __('messages.Date') }}</th>
                                <th>{{ __('messages.Changed_by') }}</th>
                                <th>Cost</th>
                                <th>{{ __('messages.Fuel Type') }}</th>
                            </tr>
                        </thead>
                         @foreach($fuelCosts as $fuelCost)
                            <tbody>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$fuelCost->created_at->format('m-d-y')}}</td>
                                    <td>{{$fuelCost->changer->first_name}}</td>
                                    <td>{{$fuelCost->new_cost}}</td>
                                    <td>{{$fuelCost->fuel_type}}</td>
                                    <td>
                                        <form method="POST" action="">
                                            @csrf
                                            <input name="_method" value="DELETE" type="hidden">
                                            {{ csrf_field() }}
                                            <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" title="View Quota" data-bs-target="#viewQuotaModal{{ $fuelCost->fuel_cost_id }}">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" title="View Quota" data-bs-target="#updateQuotaModal{{ $fuelCost->fuel_cost_id }}">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                            {{-- <button type="button" class="btn btn-secondary rounded-pill" title="Edit Fuel Quota"
                                            data-bs-toggle="modal" 
                                            data-bs-target="updateQuotaModal"
                                       >
                                            <i class="ri-edit-line"></i> 
                                        </button> --}}
                                        
                                        {{-- <button type="submit" class="btn btn-danger rounded-pill" title="Delete Quota"
                                            onclick="return confirm(&quot;Click OK to delete Fuel Quota.&quot;)">
                                            <i class="ri-close-circle-line"></i>
                                        </button> --}}
                                      </form>
                                </tr>
                            </tbody>
                            <div class="modal fade" id="viewQuotaModal{{ $fuelCost->fuel_cost_id }}" tabindex="-1" aria-labelledby="viewQuotaModal{{ $fuelCost->fuel_cost_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewQuotaModalLabel{{ $fuelCost->fuel_quata_id  }}">Fuel Cost Detail</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">@lang('messages.Fuel Type')</label>
                                                <p>{{ $fuelCost->fuel_type }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Cost:</label>
                                                <p>{{ $fuelCost->new_cost }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">@lang('messages.Changed_by')</label>
                                                <p>{{ $fuelCost->changer->first_name . ' ' .$fuelCost->changer->last_name }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Changed Date:</label>
                                                <p>{{ $fuelCost->created_at->format('Y-m-d')  }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('messages.Close')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="updateQuotaModal{{ $fuelCost->fuel_cost_id }}" tabindex="-1" aria-labelledby="updateQuotaModal{{ $fuelCost->fuel_cost_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewQuotaModalLabel{{ $fuelCost->fuel_quata_id  }}">Fuel Cost Detail</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="position-relative mb-3">
                                                <div class="mb-6 position-relative" >
                                                    <label class="form-label">@lang('messages.Cost of One Litre')</label>
                                                    <input type="number" name="Fuel_cost" class="form-control" value="{{ $fuelCost->new_cost }}">
                                                </div>
                                            </div>
                                            <div class="col-mb-3 form-group {{ $errors->has('vehicle') ? 'has-error' : '' }}">
                                                <label for="vehicle" class=" control-label">@lang('messages.Fuel Type')</label>
                                                    
                                                <select class="form-control select" id="vehicleCategory" name="fuel_type" value="{{ $fuelCost->fuel_type }}" data-fouc required>
                                                    <option value=""> {{ $fuelCost->fuel_type }}</option>
                                                    <option value="Benzene">Benzene</option>
                                                    <option value="Diesel">Diesel</option>
                                                </select>
                                            </div></br>
                                            <div class="mb-3">
                                                <label class="form-label">@lang('messages.Changed_by')</label>
                                                <p>{{ $fuelCost->changer->first_name . ' ' .$fuelCost->changer->last_name }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Changed Date:</label>
                                                <p>{{ $fuelCost->created_at->format('Y-m-d')  }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('messages.Close')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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