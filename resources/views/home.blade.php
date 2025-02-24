@extends('layouts.navigation')
@section('content')
    <style>
        html,body{margin:0px;height:100%;width:100%}
        .container{width:100%;height:100%}
    </style>

    <div class="content-page">
        <div class="content">

            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Error - </strong> {!! session('error_message') !!}
                </div>
            @endif

            @if (Session::has('success_message'))
                <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong> Success- </strong> {!! session('success_message') !!}
                </div>
            @endif

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                  <div class="row">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-secondary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="ri-questionnaire-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Temporary Requests">Total Temporary</br> Request</h6>
                                <h2 class="my-2">{{$tempReq}}</h2>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-primary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-p2p-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Permanent Request">Total Permanent</br> Request</h6>
                                <h2 class="my-2">{{$permReq}}</h2>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-secondary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-taxi-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Vehicles">Total </br>Vehicle</h6>
                                <h2 class="my-2">{{$vehicles}}</h2>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-primary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-user-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Customers">Total </br>Users</h6>
                                <h2 class="my-2">{{$users}}</h2>
                               </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="d-flex justify-content-center align-items-center">
                      <div class="col-12 col-md-8 col-lg-8">
                          <div class="card">
                              <div class="card-header  ">
                                  <h4 class="header-title d-flex justify-content-center"> Wellcome to fleet Management</h4>
                                  <p class="text-muted mb-0 d-flex justify-content-center">Where You can request vehicle, fuel, maintenance, and much more.
                                  </p>
                              </div>
                              <div class="card-body">
                                  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                      <ol class="carousel-indicators">
                                          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                                          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                                          <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                                      </ol>
                                      <div class="carousel-inner" role="listbox">
                                          <div class="carousel-item active">
                                              <img class="d-block img-fluid" src="assets/images/small/fleetMgt.png" alt="First slide">
                                          </div>
                                          <div class="carousel-item">
                                              <img class="d-block img-fluid" src="assets/images/small/addisStreet.jpg" alt="Second slide">
                                          </div>
                                          <div class="carousel-item">
                                              <img class="d-block img-fluid" src="assets/images/small/fleetDC.jpg" alt="Third slide">
                                          </div>
                                      </div>
                                      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                          data-bs-slide="prev">
                                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                          <span class="visually-hidden">Previous</span>
                                      </a>
                                      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                          data-bs-slide="next">
                                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                          <span class="visually-hidden">Next</span>
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  
                  </div>
                </div>
            </div>
          </div>
      
            
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    @endsection
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
