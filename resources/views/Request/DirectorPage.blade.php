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
                <!-- <h4 class="header-title mb-4">DIRECTOR PAGE</h4> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive"  id="table1">
                                        <h4 class="header-title mb-4">NEW REQUEST</h4>
                                        <div class="toggle-tables">
                                            <button type="button" class="btn btn-secondary rounded-pill" autofocus  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                            <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table2')">ARCHIVED REQUEST</button>
                                            <!-- Add more buttons for additional tables if needed -->
                                        </div></br>
                                        <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Requested By</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Location From</th>
                                                    <th>Location To</th>
                                                    <th>Requested At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($vehicle_requests->where('dir_approved_by', '===', null) as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->requestedBy->first_name}}</td>
                                                        <td>{{$request->vehicle_type}}</td>
                                                        <td>{{$request->start_location}}</td>
                                                        <td>{{$request->end_locations}}</td>
                                                        <td>{{$request->created_at}}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#standard-modal-{{ $loop->index }}" title="Show"><i class=" ri-eye-line"></i></button>
                                                            @if($request->dir_approved_by === Null && $request->director_reject_reason === Null)
                                                            <button id="acceptButton" type="button" class="btn btn-primary rounded-pill" title="Accept" onclick="confirmFormSubmission('approvalForm-{{ $loop->index }}')"><i class="ri-checkbox-circle-line"></i></button>
                                                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <form id="approvalForm-{{ $loop->index }}" method="POST" action="{{ route('director_approve_request') }}" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="request_id" value="{{ $request->request_id }}">
                                                </form>
                                                <!-- show all the information about the request modal -->
                                                <div id="standard-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Request Details </h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <dl class="row mb-0">
                                                                    <dt class="col-sm-3">Request reason</dt>
                                                                    <dd class="col-sm-9">{{$request->purpose}}.</dd>

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
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>
                                                <!-- end show modal -->
                                                <!-- this is for the assign  modal -->
                                                <div class="modal fade" id="staticBackdrop-{{ $loop->index }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Reject reason {{ $request->request_id }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div> <!-- end modal header -->
                                                            <form method="POST" action="{{route('director_reject_request')}}">
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
                                    <div class="table-responsive"  id="table2" style="display:none">
                                        <h4 class="header-title mb-4" >ARCHIVED REQUEST</h4>
                                        <div class="toggle-tables">
                                            <button type="button" class="btn btn-outline-secondary rounded-pill"  onclick="toggleDiv('table1')">PENDING REQUEST</button>
                                            <button type="button" class="btn btn-secondary rounded-pill"  onclick="toggleDiv('table2')">ARCHIVED REQUEST</button>
                                            <!-- Add more buttons for additional tables if needed -->
                                        </div></br>
                                        <table class="table table-centered mb-0 table-nowrap" id="inline-editable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Requested By</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Location From</th>
                                                    <th>Location To</th>
                                                    <th>Requested At</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @foreach($vehicle_requests->where('dir_approved_by', '!==', null) as $request)
                                                <tbody>
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$request->requestedBy->first_name}}</td>
                                                        <td>{{$request->vehicle_type}}</td>
                                                        <td>{{$request->start_location}}</td>
                                                        <td>{{$request->end_locations}}</td>
                                                        <td>{{$request->created_at}}</td>
                                                        <td> @if($request->dir_approved_by !== null && $request->director_reject_reason === null)
                                                                <p class="btn btn-primary ">ACCEPTED</p>
                                                             @elseif($request->dir_approved_by !== null && $request->director_reject_reason !== null)
                                                                <p class="btn btn-danger">REJECTED
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#archived-modal-{{ $loop->index }}" title="Show"><i class=" ri-eye-line"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                   
                                                <!-- show all the information about the request modal -->
                                                <div id="archived-modal-{{ $loop->index }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
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
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>
                                                <!-- end show modal -->
                                            @endforeach
                                        </table>
                                    </div> 
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
  

  function confirmFormSubmission(formId) {
        if (confirm("Are you sure you want to accept this request?")) {
            var form = document.getElementById(formId);
            form.submit();
        }
    }
   
    function toggleDiv(targetId) {
        const allDivs = document.querySelectorAll('.table-responsive');
        allDivs.forEach(div => {
            if (div.id === targetId) {
                div.style.display = 'block';// Show the target div
            } else {
                div.style.display = 'none';// Hide other divs
            }
        });
    }
</script>
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

<!-- Datatables js -->
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        
<!-- Bootstrap Wizard Form js -->
<script src="{{ asset('assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

<!-- Wizard Form Demo js -->
<script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>

<!-- Datatable Demo Aapp js -->
<script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>    
@endsection
