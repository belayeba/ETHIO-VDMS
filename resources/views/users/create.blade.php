<!DOCTYPE html>
<html lang="en" data-sidenav-size="compact">
@include('layouts.main-link')
@include('layouts.header')
@include('layouts.sidebar')
@include('layouts.setting')


<body>
    <!-- Begin page -->
    <div class="wrapper">

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

                    <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">User Create</h4>
                                </div>
                                <div class="card-body">
                                    <form class="needs-validation" action="{{ route('users.store') }}" novalidate>
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip01">First name</label>
                                            <input type="text" class="form-control" name="first_name" id="validationTooltip01"
                                                placeholder="First name" value="Mark" required>
                                            <div class="valid-tooltip">
                                                Looks good!
                                            </div>
                                            <div class="invalid-tooltip">
                                                Please enter first name.
                                            </div>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Last name</label>
                                            <input type="text" class="form-control" name="last_name" id="validationTooltip02"
                                                placeholder="Last name" value="Otto" required>
                                            <div class="valid-tooltip">
                                                Looks good!
                                            </div>
                                            <div class="invalid-tooltip">
                                                Please enter last name.
                                            </div>
                                        </div>

                                      <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">select Role</label>
                                            <select class="form-control" id="role_id" name="roles">
                                                    <option value="" style="display: none;"  disabled selected>Select</option>
                                                @foreach ($roles as $key => $role)
                                                    <option value="{{ $key }}" >
                                                        {{ $role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
                                        </div>

                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltipUsername">Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    id="validationTooltipUsernamePrepend">@</span>
                                                <input type="text" class="form-control" name="email" id="validationTooltipUsername"
                                                    placeholder="Username"
                                                    aria-describedby="validationTooltipUsernamePrepend" required>
                                                <div class="invalid-tooltip">
                                                    Please choose a unique and valid username.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip03">Password</label>
                                            <input type="text" class="form-control" id="validationTooltip03"
                                                placeholder="password" name="password" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip04">Username</label>
                                            <input type="text" class="form-control" name="username" id="validationTooltip04"
                                                placeholder="State" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid state.
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Submit form</button>
                                    </form>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                </div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:18 GMT -->
</html>
