<!DOCTYPE html>
<html lang="en">
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

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="profile-bg-picture"
                                style="background-image:url('assets/images/bg-profile.jpg')">
                                <span class="picture-bg-overlay"></span>
                                <!-- overlay -->
                            </div>
                            <!-- meta -->
                            <div class="profile-user-box">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="profile-user-img"><img src="assets/images/users/avatar-1.jpg" alt=""
                                                class="avatar-lg rounded-circle"></div>
                                        <div class="">
                                            <h4 class="mt-4 fs-17 ellipsis">Michael A. Franklin</h4>
                                            <p class="font-13"> User Experience Specialist</p>
                                            <p class="text-muted mb-0"><small>California, United States</small></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <button type="button" class="btn btn-soft-danger">
                                                <i class="ri-settings-2-line align-text-bottom me-1 fs-16 lh-1"></i>
                                                Edit Profile
                                            </button>
                                            <a class="btn btn-soft-info" href="#"> <i class="ri-check-double-fill fs-18 me-1 lh-1"></i> Following</a>
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
                                                    data-bs-target="#user-activities" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#user-activities">Activities</a></li>
                                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#edit-profile" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#edit-profile">Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#projects" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#projects">Projects</a></li>
                                        </ul>

                                        <div class="tab-content m-0 p-4">
                                            <div class="tab-pane active" id="aboutme" role="tabpanel"
                                                aria-labelledby="home-tab" tabindex="0">
                                                <div class="profile-desk">
                                                    <h5 class="text-uppercase fs-17 text-dark">Johnathan Deo</h5>
                                                    <div class="designation mb-4">PRODUCT DESIGNER (UX / UI / Visual
                                                        Interaction)</div>
                                                    <p class="text-muted fs-16">
                                                        I have 10 years of experience designing for the web, and
                                                        specialize
                                                        in the areas of user interface design, interaction design,
                                                        visual
                                                        design and prototyping. I’ve worked with notable startups
                                                        including
                                                        Pearl Street Software.
                                                    </p>

                                                    <h5 class="mt-4 fs-17 text-dark">Contact Information</h5>
                                                    <table class="table table-condensed mb-0 border-top">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Url</th>
                                                                <td>
                                                                    <a href="#" class="ng-binding">
                                                                        www.example.com
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>
                                                                    <a href="#" class="ng-binding">
                                                                        jonathandeo@example.com
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Phone</th>
                                                                <td class="ng-binding">(123)-456-7890</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Skype</th>
                                                                <td>
                                                                    <a href="#" class="ng-binding">
                                                                        jonathandeo123
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div> <!-- end profile-desk -->
                                            </div> <!-- about-me -->

                                            <!-- Activities -->
                                            <div id="user-activities" class="tab-pane">
                                                <div class="timeline-2">
                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">5 minutes ago</div>
                                                            <p><strong><a href="#" class="text-info">John
                                                                        Doe</a></strong>Uploaded a photo</p>
                                                            <img src="assets/images/small/small-3.jpg" alt=""
                                                                height="40" width="60" class="rounded-1">
                                                            <img src="assets/images/small/small-4.jpg" alt=""
                                                                height="40" width="60" class="rounded-1">
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">30 minutes ago</div>
                                                            <p><a href="#" class="text-info">Lorem</a> commented your
                                                                post.
                                                            </p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">59 minutes ago</div>
                                                            <p><a href="#" class="text-info">Jessi</a> attended a meeting
                                                                with<a href="#" class="text-success">John Doe</a>.</p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">5 minutes ago</div>
                                                            <p><strong><a href="#" class="text-info">John
                                                                        Doe</a></strong> Uploaded 2 new photos</p>
                                                            <img src="assets/images/small/small-2.jpg" alt=""
                                                                height="40" width="60" class="rounded-1">
                                                            <img src="assets/images/small/small-1.jpg" alt=""
                                                                height="40" width="60" class="rounded-1">
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">30 minutes ago</div>
                                                            <p><a href="#" class="text-info">Lorem</a> commented your
                                                                post.
                                                            </p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="time-item">
                                                        <div class="item-info ms-3 mb-3">
                                                            <div class="text-muted">59 minutes ago</div>
                                                            <p><a href="#" class="text-info">Jessi</a> attended a meeting
                                                                with<a href="#" class="text-success">John Doe</a>.</p>
                                                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                    elit.
                                                                    Aliquam laoreet tellus ut tincidunt euismod. "</em>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- settings -->
                                            <div id="edit-profile" class="tab-pane">
                                                <div class="user-profile-content">
                                                    <form>
                                                        <div class="row row-cols-sm-2 row-cols-1">
                                                            <div class="mb-2">
                                                                <label class="form-label" for="FullName">Full
                                                                    Name</label>
                                                                <input type="text" value="John Doe" id="FullName"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="Email">Email</label>
                                                                <input type="email" value="first.last@example.com"
                                                                    id="Email" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="web-url">Website</label>
                                                                <input type="text" value="Enter website url"
                                                                    id="web-url" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="Username">Username</label>
                                                                <input type="text" value="john" id="Username"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="Password">Password</label>
                                                                <input type="password" placeholder="6 - 15 Characters"
                                                                    id="Password" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="RePassword">Re-Password</label>
                                                                <input type="password" placeholder="6 - 15 Characters"
                                                                    id="RePassword" class="form-control">
                                                            </div>
                                                            <div class="col-sm-12 mb-3">
                                                                <label class="form-label" for="AboutMe">About Me</label>
                                                                <textarea style="height: 125px;" id="AboutMe"
                                                                    class="form-control">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</textarea>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" type="submit"><i
                                                                class="ri-save-line me-1 fs-16 lh-1"></i> Save</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- profile -->
                                            <div id="projects" class="tab-pane">
                                                <div class="row m-t-10">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name</th>
                                                                        <th>Start Date</th>
                                                                        <th>Due Date</th>
                                                                        <th>Status</th>
                                                                        <th>Assign</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>Velonic Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>07/05/2015</td>
                                                                        <td><span class="badge bg-info">Work
                                                                                in Progress</span></td>
                                                                        <td>Techzaa</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>Velonic Frontend</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>07/05/2015</td>
                                                                        <td><span
                                                                                class="badge bg-success">Pending</span>
                                                                        </td>
                                                                        <td>Techzaa</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>Velonic Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>07/05/2015</td>
                                                                        <td><span class="badge bg-pink">Done</span>
                                                                        </td>
                                                                        <td>Techzaa</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>Velonic Frontend</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>07/05/2015</td>
                                                                        <td><span class="badge bg-purple">Work
                                                                                in Progress</span></td>
                                                                        <td>Techzaa</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td>Velonic Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>07/05/2015</td>
                                                                        <td><span class="badge bg-warning">Coming
                                                                                soon</span></td>
                                                                        <td>Techzaa</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div>
                <!-- end row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <script>document.write(new Date().getFullYear())</script> © Velonic - Theme by <b>Techzaa</b>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Chart.js -->
    <script src="assets/vendor/chart.js/chart.min.js"></script>

    <!-- Profile Demo App js -->
    <script src="assets/js/pages/profile.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/pages-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:29:56 GMT -->
</html>