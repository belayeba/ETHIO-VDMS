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
                                {{-- <th>Changed By</th> --}}
                                {{-- <th>Changed Date</th> --}}
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
                                    <td>
                                        <form method="POST" action=""accept-charset="UTF-8">
                                            {{-- @method('DELETE') --}}
                                            @csrf
                                            <input name="_method" value="DELETE" type="hidden">
                                            {{ csrf_field() }}
                                            <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" title="View Quota" data-bs-target="#viewQuotaModal{{ $fuelQuata->fuel_quata_id }}">
                                                <i class="ri-eye-line"></i>
                                            </button>

                                            <button type="button" class="btn btn-info rounded-pill" title="Edit Fuel Quota"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#quota_modal_{{$loop->index}}"
                                            data-vehicle="{{ $fuelQuata->vehicle->plate_number }}"
                                            data-old-quota="{{ $fuelQuata->old_quata }}"
                                            data-new-quota ="{{ $fuelQuata->new_quata }}"
                                            data-changed-by ="{{ $fuelQuata->changer->first_name }}"
                                            data-changed-date  ="{{ $fuelQuata->created_at->format('Y-m-d') }}">
                                            <i class="ri-edit-line"></i> 
                                        </button>
                                        
                                        {{-- <button type="submit" class="btn btn-danger rounded-pill" title="Delete Quota"
                                            onclick="return confirm(&quot;Click OK to delete Fuel Quota.&quot;)">
                                            <i class="ri-close-circle-line"></i>
                                        </button> --}}
                                      </form>
                                </tr>
                            </tbody>
                            <div id="quota_modal_{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('quota.update', $fuelQuata) }}" class="ps-3 pe-3">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="fuel_quata_id" value="{{ $fuelQuata->fuel_quata_id  }}">
                            
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Vehicle</label>
                                                    <select id="name" name="name" class="form-select" required>
                                                        <option value="{{ $fuelQuata->fuel_quata_id  }}" {{ $fuelQuata->fuel_quata_id  == $fuelQuata->fuel_quata_id  ? 'selected' : '' }}>{{  $fuelQuata->vehicle->plate_number  }}</option>
                                                    </select>
                                                  </div>
                            
                                                <div class="mb-3">
                                                    <label for="old_quota{{ $loop->index }}" class="form-label">Old Quota</label>
                                                    <input class="form-control" type="number" name="old_quota" id="old_quota{{ $loop->index }}" value="{{ $fuelQuata->old_quata }}">
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="new_quota{{ $loop->index }}" class="form-label">New Quota</label>
                                                    <input class="form-control" type="number" name="new_quota" id="new_quota{{ $loop->index }}" value="{{ $fuelQuata->new_quata }}">
                                                </div>
                            
                                                <div class="mb-3 text-center">
                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                    <a type="button" href="{{ route('quota.index') }}" class="btn btn-warning">Cancel</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="viewQuotaModal{{ $fuelQuata->fuel_quata_id  }}" tabindex="-1" aria-labelledby="viewQuotaModalLabel{{ $fuelQuata->fuel_quata_id  }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewQuotaModalLabel{{ $fuelQuata->fuel_quata_id  }}">Fuel Quota Detail</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Vehicle:</label>
                                                <p>{{ $fuelQuata->vehicle->plate_number }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Old Quota:</label>
                                                <p>{{ $fuelQuata->old_quata }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New Quota:</label>
                                                <p>{{ $fuelQuata->new_quata}}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Changed By:</label>
                                                <p>{{ $fuelQuata->changer->first_name }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Changed Date:</label>
                                                <p>{{ $fuelQuata->created_at->format('Y-m-d')  }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
   var editButtons = document.querySelectorAll('.edit-quota-btn');

   editButtons.forEach(function(button) {
       button.addEventListener('click', function() {
           var vehicle = this.getAttribute('data-vehicle');
           var old_quota = this.getAttribute('data-old-quota');
           var new_quota = this.getAttribute('data-new-quota');
           var index = this.getAttribute('data-bs-target').split('_').pop();

           // Populate the modal input fields with the selected driver's details
           document.getElementById('vehicle' + index).value = vehicle;
           document.getElementById('old_quota' + index).value = old_quota;
           document.getElementById('new_quota' + index).value = new_quota;
       });
   });
});

   </script>
                                     
 <!-- Dropzone File Upload js -->
 <script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>

<!-- File Upload Demo js -->
<script src="{{ asset('assets/js/pages/fileupload.init.js') }}"></script>
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
@endsection