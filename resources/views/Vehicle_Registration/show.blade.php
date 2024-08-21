@extends('layouts.navigation')
@section('content')

<div class="wrapper">

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid">
        <div class="row">
<div class="col-6">
    <div class="card">
        <div class="card-header">
            <h4 class="header-title mb-0">Vehicle Registration</h4>
        </div>
        <div class="card-body">
            <div id="rootwizard">
                    <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                        <li class="nav-item" data-target-form="#accountForm">
                            <a href="#first" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                <i class="ri-account-circle-line fw-normal fs-20 align-middle me-1"></i>
                                <span class="d-none d-sm-inline">Vehicle Info</span>
                            </a>
                        </li>
                        <li class="nav-item" data-target-form="#profileForm">
                            <a href="#second" data-bs-toggle="tab" data-toggle="tab"  class="nav-link rounded-0 py-2">
                                <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                <span class="d-none d-sm-inline">Vehicle Profile</span>
                            </a>
                        </li>
                        <li class="nav-item" data-target-form="#otherForm">
                            <a href="#third" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                <span class="d-none d-sm-inline">Vehicle form</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mb-0 b-0">

                        <div class="tab-pane" id="first">
                            <form id="accountForm" method="post" action="#" class="form-horizontal">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="userName3">Vin</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="userName3" name="userName3" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="password3"> Make</label>
                                            <div class="col-md-9">
                                                <input type="password" id="password3" name="password3" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="confirm3">Model</label>
                                            <div class="col-md-9">
                                                <input type="password" id="confirm3" name="confirm3" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="confirm3">Year</label>
                                            <div class="col-md-9">
                                                <input type="password" id="confirm3" name="confirm3" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="confirm3">Plate Number</label>
                                            <div class="col-md-9">
                                                <input type="password" id="confirm3" name="confirm3" class="form-control" required>
                                            </div>
                                        </div>

                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </form>
                            <ul class="list-inline wizard mb-0">
                                <li class="next list-inline-item float-end">
                                    <a href="javascript:void(0);" class="btn btn-info">Next <i class="ri-arrow-right-line ms-1"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-pane fade" id="second">
                            <form id="profileForm" method="post" action="#" class="form-horizontal">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="name3">Registration Date</label>
                                            <div class="col-md-9">
                                                <input type="date" id="name3" name="name3" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="surname3">Mileage</label>
                                            <div class="col-md-9">
                                                <input type="text" id="surname3" name="surname3" class="form-control" required>
                                            </div>
                                        </div>
                            
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="email3">Vehicle Type</label>
                                            <div class="col-md-9">
                                                <input type="email" id="email3" name="email3" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="surname3">Vehicle Category</label>
                                            <div class="col-md-9">
                                                <input type="text" id="surname3" name="surname3" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="email3">Fuel Amount</label>
                                            <div class="col-md-9">
                                                <input type="email" id="email3" name="email3" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="email3">Fuel Type</label>
                                            <div class="col-md-9">
                                                <input type="email" id="email3" name="email3" class="form-control" required>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </form>
                            <ul class="pager wizard mb-0 list-inline">
                                <li class="previous list-inline-item">
                                    <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                </li>
                                <li class="next list-inline-item float-end">
                                    <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-pane fade" id="third">
                            <form id="otherForm" method="post" action="#" class="form-horizontal"></form>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="name3">Last Service</label>
                                            <div class="col-md-9">
                                                <input type="text" id="name3" name="name3" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="name3">Next Service</label>
                                            <div class="col-md-9">
                                                <input type="text" id="name3" name="name3" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label" for="name3">Notes</label>
                                            <div class="col-md-9">
                                                <input type="text" id="name3" name="name3" class="form-control" required>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </form>
                            <ul class="pager wizard mb-0 list-inline mt-1">
                                <li class="previous list-inline-item">
                                    <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Profile</button>
                                </li>
                                <li class="next list-inline-item float-end">
                                    <button type="button" class="btn btn-info">Submit</button>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
         
            
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Vehicle List</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="lms_table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Plate Number</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Driver</th>
                                                    {{-- <th>status</th> --}}
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table rows will be populated here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

                    </div> <!-- tab-content -->
                </div> <!-- end #rootwizard-->
            </form>
</div>
        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div> <!-- end col -->
</div> 
<

        </div>
    </div>
</div>



<script src="assets/js/vendor.min.js"></script>
        
<!-- Bootstrap Wizard Form js -->
<script src="assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

<!-- Wizard Form Demo js -->
<script src="assets/js/pages/form-wizard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

@endsection