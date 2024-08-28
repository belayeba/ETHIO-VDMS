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
                    <h4 class="header-title">Add vehicle part for inspection</h4>
                </div>
                <div class="card-body"> 
                    <form action="{{route('vehicle_parts.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

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
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" >
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Enter Name of vehicle part">

                                            </div>
                                        </div>

                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" >
                                                <label class="form-label">Notes</label>
                                                <input type="text" name="notes" class="form-control" placeholder="Enter notes for vehicle part">
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
                                <th>Part</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                       
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </tbody>
                            
                            <!-- edit the information of the request modal -->
                                <div id="standard-modal-" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Request Details</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data">
                                           
                                                <div class="tab-pane" id="account-2">
                                                    <div class="row">
                                                        <div class="position-relative mb-3">
                                                            <div class="mb-6 position-relative" id="datepicker1">
                                                                <label class="form-label">Name</label>
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mb-3">
                                                                <label class="form-label">Note</label>
                                                               
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