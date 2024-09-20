@extends('layouts.navigation')

@section('content')

<div class="wrapper">
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
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                    <li class="breadcrumb-item active">Daily km Report</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Daily km Report</h4>
                        </div>
                    </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="box_header common_table_header">
                                            <div class="main-title d-md-flex">
                                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Filter Report</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="">
                                    
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    </br>
                                                </div>
                                            </div>
                                            <div class="row">
                    <div class="col-lg-4">
                        <label for="selectName" class="form-label">Plate Numbe</label>
                        <select id="editVehicleType" name="vehicle_type" class="form-select" required onchange="toggleEditFields()">
                            <option value="Plate Numbe">Plate Numbe</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="selectName" class="form-label">Name</label>
                        <select id="selectName" name="vehicle_type" class="form-select" required onchange="toggleEditFields()">
                            <option value="Name">Name</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="selectDepartment" class="form-label">Department</label>
                        <select id="selectDepartment" name="vehicle_type" class="form-select" required onchange="toggleEditFields()">
                            <option value="Department">Department</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="col-lg-4">
                    <label for="selectDepartment" class="form-label">Date Range Pick With Times</label>
                        <input type="text" class="form-control date" id="daterangetime" data-toggle="date-picker" data-time-picker="true" data-locale= "{'format': 'DD/MM hh:mm A'}">
                    </div>
                   </div>
                                                <div class="row">
                                                <div class="col-lg-12 text-center">
                                                <li class="next list-inline-item float-end">
                                                <button type="button" class="btn btn-info">Filter <i class="ri-arrow-right-line ms-1"></i></button>
                                            </li>
                                            </div>

                                                    
                                                </div>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Daily km Report</h4>
                            <p class="text-muted mb-0">
                                The Buttons extension for DataTables provides a common set of options, API
                                methods and styling to display buttons on a page
                                that will interact with a DataTable.
                            </p>
                        </div>
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Plate Number</th>
                                        <th>Morning KM</th>
                                        <th>Night KM</th>
                                        <th>Daily KM Difference </th>

                                    </tr>
                                </thead>


                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>

                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>

                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009/01/12</td>

                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2012/03/29</td>

                                    </tr>
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div> <!-- end row-->


    </div> <!-- content -->

</div>

</div>

@endsection