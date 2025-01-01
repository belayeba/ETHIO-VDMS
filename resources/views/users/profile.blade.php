
@extends('layouts.navigation')

@section('content')

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile-bg-picture"
                            style="background-image:url('assets/images/EAII_background.jpg')">
                            <span class="picture-bg-overlay"></span>
                            <!-- overlay -->
                        </div>
                        <!-- meta -->
                        <div class="profile-user-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="profile-user-img"><img src="assets/images/users/no-avatar.png" alt=""
                                            class="avatar-lg rounded-circle"></div>
                                    <div class="">
                                        <h4 class="mt-4 fs-17 ellipsis">{{ $users->first_name }}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ meta -->
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-0">
                            <div class="card-body p-0">
                                <div class="profile-content">
                                    <ul class="nav nav-underline nav-justified gap-0">
                                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#aboutme" type="button" role="tab"
                                                aria-controls="home" aria-selected="true" href="#aboutme">About</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#edit-profile" type="button" role="tab"
                                            aria-controls="home" aria-selected="true"
                                            href="#edit-profile">Settings</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content m-0 p-4">
                                        <div class="tab-pane active" id="aboutme" role="tabpanel"
                                            aria-labelledby="home-tab" tabindex="0">
                                            <div class="profile-desk">
                                                <h5 class="text-uppercase fs-17 text-dark">{{ $users->first_name }} {{ $users->middle_name }} {{ $users->last_name }}</h5>
                                                
                                                <h5 class="mt-4 fs-17 text-dark">Contact Information</h5>
                                                <table class="table table-condensed mb-0 border-top">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Email</th>
                                                            <td>
                                                                <a href="#" class="ng-binding">
                                                                    {{$users->email}}
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Phone</th>
                                                            <td class="ng-binding">{{$users->phone_number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Department</th>
                                                            <td>
                                                                <a href="#" class="ng-binding">
                                                                    {{$users->department->name ?? 'Not Assigned'}}
                                                                </a>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div> <!-- end profile-desk -->
                                        </div> <!-- about-me -->


                                        <!-- settings -->
                                        <div id="edit-profile" class="tab-pane">
                                            <div class="user-profile-content">
                                                <form method="POST" action="{{route('user.profile.store')}}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12 col-md-8 col-lg-6">
                                                            <div class="mb-4">
                                                                <label class="form-label" for="CurrentPassword">Current Password</label>
                                                                <input type="password" name="old_password" placeholder="Enter current password" id="CurrentPassword" class="form-control" required>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="form-label" for="NewPassword">New Password</label>
                                                                <input type="password" name="new_password" placeholder="6 - 8 Characters" id="NewPassword" class="form-control" required>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="form-label" for="ConfirmPassword">Confirm Password</label>
                                                                <input type="password" name="confirm_password" placeholder="6 - 8 Characters" id="ConfirmPassword" class="form-control" required>
                                                            </div>
                                                            <div class="mt-4">
                                                                <button class="btn btn-primary btn-sm" type="submit">
                                                                    <i class="ri-save-line me-1 fs-16 lh-1"></i> Change Password
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
    <!-- content -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
