@extends('layouts.navigation')
@section('content')

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
                                    <h4 class="header-title mb-4">Director Page</h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Requested By</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Location From</th>
                                                    <th>Location To</th>
                                                    <th>Purpose</th>
                                                    <th>Requested At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($vehicle_requests as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->requestedBy->first_name}}</td>
                                                        <td>{{$request->vehicle_type}}</td>
                                                        <td>{{$request->start_location}}</td>
                                                        <td>{{$request->end_locations}}</td>
                                                        <td>{{$request->purpose}}</td>
                                                        <td>{{$request->created_at}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="show"><i class=" ri-eye-line"></i></button>
                                                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#staticaccept-{{ $loop->index }}" title="accept"><i class=" ri-checkbox-circle-line"></i></button>
                                                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticreject-{{ $loop->index }}" title="reject"><i class=" ri-close-circle-fill"></i></button>
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
                                                                <dl class="row mb-0">
                                                                    <dt class="col-sm-3">Request reason</dt>
                                                                    <dd class="col-sm-9">{{$request->purpose}}.</dd>

                                                                    <dt class="col-sm-3">Request status</dt>
                                                                    <dd class="col-sm-9">{{$request->status}}.</dd>

                                                                    <dt class="col-sm-3">Requested vehicle</dt>
                                                                    <dd class="col-sm-9">
                                                                        <p>{{$request->vehicle_type}}.</p>
                                                                    </dd>

                                                                    <dt class="col-sm-3">Start date and Time</dt>
                                                                    <dd class="col-sm-9">{{$request->start_date}}, {{$request->start_time}}.</dd>

                                                                    <dt class="col-sm-3">Return date and Time</dt>
                                                                    <dd class="col-sm-9">{{$request->end_date}}, {{$request->end_time}}.</dd>

                                                                    <dt class="col-sm-3">Location From and To</dt>
                                                                    <dd class="col-sm-9">{{$request->start_location}}, {{$request->end_locations}}.</dd>

                                                                    <dt class="col-sm-3 text-truncate">passenger</dt>
                                                                
                                                                    <dd class="col-sm-9">  @foreach($request->peoples as $person) {{$person->user->first_name}}.</br> @endforeach</dd>

                                                                    <dt class="col-sm-3">Materials</dt>
                                                                    <dd class="col-sm-9">
                                                                        @foreach($request->materials as $material)
                                                                            <p>Material name: {{ $material->material_name }},</br> Material Weight: {{ $material->weight }}.</p>
                                                                        @endforeach</dd>
                                                                    
                                                                    </dd>
                                                                </dl>  
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                                                                <form >
                                                                    
                                                                    <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                                    <div class="form-floating"  id="vehicleselect" style="display:none">
                                                                        <select class="form-select" id="floatingSelect"
                                                                            aria-label="Floating label select example">
                                                                            <option selected>Vehicles</option>
                                                                            <option value="1">One</option>
                                                                            <option value="2">Two</option>
                                                                            <option value="3">Three</option>
                                                                        </select>
                                                                        <label for="floatingSelect">Select a Vehicle</label>
                                                                    </div>  
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>
                                                <!-- end show modal -->
                                                <!-- this is for the assign  modal -->
                                                <div class="modal fade" id="staticaccept-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Assign Vehicle</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div> <!-- end modal header -->
                                                            <form method="POST" action="{{route('simirit_approve')}}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="col-lg-6">
                                                                        <h5 class="mb-3">Select Vehicle</h5>
                                                                        <div class="form-floating">
                                                                            <select name="assigned_vehicle_id" class="form-select" id="vehicleselection"
                                                                                aria-label="Floating label select example" required>
                                                                                <option value="" selected>Select</option>
                                                                               @foreach ($vehicles as $item)
                                                                                   <option value="{{$item->vehicle_id}}">{{$item->plate_number}}</option>
                                                                               @endforeach
                                                                            </select>
                                                                            <label for="floatingSelect">vehicle selection</label>
                                                                        </div>
                                                                        <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                                    </div>
                                                                </div>
                                                                <iframe src="" frameborder="0"></iframe>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" style="display:none" id="assignBtn">Get Inspection</button>
                                                                    <button type="submit" class="btn btn-primary">Assign</button>
                                                                </div> <!-- end modal footer -->
                                                            </form>                                                                    
                                                        </div> <!-- end modal content-->
                                                    </div> <!-- end modal dialog-->
                                                </div>
                                                <script>    
                                                    const vehicleSelect = document.getElementById('vehicleselection');
                                                    const InspectButton = document.getElementById('assignBtn');
                                                    InspectButton.style.display = 'none';

                                                    vehicleSelect.addEventListener('change', function() {
                                                        if (vehicleSelect.value) {
                                                            InspectButton.style.display = 'block';
                                                        } else {
                                                            InspectButton.style.display = 'none';
                                                        }
                                                    });
                                                    document.getElementById('assignBtn').addEventListener('click', function() {
                                                        var selectedCarId = document.getElementById('vehicleselection').value;
                                                        console.log(selectedCarId);
                                                        
                                                        window.location.href = "{{ route('inspection.ByVehicle') }}?vehicleId=" + selectedCarId;
                                                    });
                                                </script>
                                                </script>
                                                <!-- end assign modal -->
                                                <!-- this is for the assign  modal -->
                                                <div class="modal fade" id="staticreject-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Reject request</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div> <!-- end modal header -->
                                                            <form method="POST" action="{{route('simirit_reject')}}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="col-lg-6">
                                                                        <h5 class="mb-3"></h5>
                                                                        <div class="form-floating">
                                                                        <input type="hidden" name="request_id" value="{{$request->request_id}}">
                                                                        <textarea class="form-control" name="reason" style="height: 60px;" required></textarea>
                                                                        <label for="floatingTextarea">Reason</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                                </div> <!-- end modal footer -->
                                                            </form>                                                                    
                                                        </div> <!-- end modal content-->
                                                    </div> <!-- end modal dialog-->
                                                </div>
                                                <!-- end assign modal -->
                                            @endforeach
                                        </table>
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
    <script>
         function vehicleselection() {
            // vehicleselect
            document.getElementById('vehicleselect').style.display = "block";
        }
        // document.getElementById('declineButton').addEventListener('click', function() {
        // document.getElementById('reasonInput').style.display = "block";
        // });

        // document.getElementById('submitReason').addEventListener('click', function() {
        // var reason = document.getElementById('declineReason').value;

        // if (reason) {
        //     // Append the reason to the form before submitting
        //     var form = document.getElementById('approvalForm');
        //     var reasonInput = document.createElement('input');
        //     reasonInput.type = 'hidden';
        //     reasonInput.name = 'decline_reason';
        //     reasonInput.value = reason;
        //     form.appendChild(reasonInput);
            
        //     // Submit the form with the reason included
        //     form.submit();
        // }
        // });
    </script> 
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

<!-- Datatables js -->
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>


<!-- Datatable Demo Aapp js -->
<script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>    
@endsection
