@extends('layouts.navigation')

@section('content')
    <div class="content-page">
        <div class="content">

            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-8" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Error - </strong> {!! session('error_message') !!}
                </div>
            @endif

            @if (Session::has('success_message'))
                <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-4" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Success </strong>
                </div>
            @endif
            <!-- Start Content-->
            <div class="container-fluid">

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">User Create</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" class="needs-validation" action="{{ route('users.store') }}" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip01">First name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                id="validationTooltip01" placeholder="First name" required>
                                            <!-- <div class="valid-tooltip">
                                                                                Looks good!
                                                                            </div> -->
                                            <div class="invalid-tooltip">
                                                Please enter first name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Middle name</label>
                                            <input type="text" class="form-control" name="middle_name"
                                                id="validationTooltip02" placeholder="Middle name" required>
                                            <div class="invalid-tooltip">
                                                Please enter Middle name.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Last name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                id="validationTooltip02" placeholder="Last name" required>
                                            <div class="invalid-tooltip">
                                                Please enter last name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip04">Username</label>
                                            <input type="text" class="form-control" name="username"
                                                id="validationTooltip04" placeholder="username" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid Username.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Select Role</label>
                                            <select class="form-control" id="role_id" name="roles">
                                                <option value="" style="display: none;" disabled selected>Select
                                                </option>
                                                @foreach ($roles as $key => $role)
                                                    <option value="{{ $key }}">
                                                        {{ $role }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Select Department</label>
                                            <select class="form-control" id="department_id" name="department">
                                                <option value="" disabled selected>Select</option>
                                                @foreach ($department as $dep)
                                                    <option value="{{ $dep->department_id }}">
                                                        {{ $dep->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltipUsername">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    id="validationTooltipUsernamePrepend">@</span>
                                                <input type="email" class="form-control" name="email"
                                                    id="validationTooltipUsername" placeholder="Email"
                                                    aria-describedby="validationTooltipUsernamePrepend" required>
                                                <div class="invalid-tooltip">
                                                    Please choose a valid Email.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip04">Phone</label>
                                            <input type="mob" class="form-control" name="phone"
                                                id="validationTooltip04" pattern="^\+251\d{9}$" placeholder="Start with +251" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid phone.no.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip03">Password</label>
                                            <input type="text" class="form-control" id="validationTooltip03"
                                                placeholder="password" name="password" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid Password.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip03">Confirm Password</label>
                                            <input type="text" class="form-control" id="validationTooltip03"
                                                placeholder="confirm password" name="confirm" required>
                                            <div class="invalid-tooltip">
                                                Please provide a confirmed password.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">Save</button>

                            </form>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
                {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
            
            <script src="{{ asset('assets/js/app.min.js') }}"></script>
        @endsection
        
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        
