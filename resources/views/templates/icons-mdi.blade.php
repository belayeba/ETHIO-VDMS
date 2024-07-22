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
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Icons</a></li>
                                            <li class="breadcrumb-item active">Material Design Icons</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Material Design Icons</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row icons-list-demo">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">New Icons</h4>
                                        <p class="card-title-desc mb-2">Use <code>&lt;i class="mdi mdi-*-*"&gt;&lt;/i&gt;</code> class.<span class="badge bg-success">v 6.5.95</span>.</p>
                                        <div class="row icons-list-demo" id="newIcons"></div>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">All Icons</h4>
                                        <div class="row icons-list-demo" id="icons"></div>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Size</h4>
                                        <div class="row icons-list-demo">
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-18px mdi-account"></i> mdi-18px
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-24px mdi-account"></i> mdi-24px
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-36px mdi-account"></i> mdi-36px
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-48px mdi-account"></i> mdi-48px
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Rotate</h4>
                                        <div class="row icons-list-demo">
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-rotate-45 mdi-account"></i> mdi-rotate-45
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-rotate-90 mdi-account"></i> mdi-rotate-90
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-rotate-135 mdi-account"></i> mdi-rotate-135
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-rotate-180 mdi-account"></i> mdi-rotate-180
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-rotate-225 mdi-account"></i> mdi-rotate-225
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-rotate-270 mdi-account"></i> mdi-rotate-270
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-rotate-315 mdi-account"></i> mdi-rotate-315
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Spin</h4>
                                        <div class="row icons-list-demo">
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-spin mdi-loading"></i> mdi-spin
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                                <i class="mdi mdi-spin mdi-star"></i> mdi-spin
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

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

        <!-- Remixicons Icons Demo js -->
        <script src="assets/js/pages/icons-mdi.init.js"></script>        
        
        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>

<!-- Mirrored from techzaa.getappui.com/velonic/layouts/icons-mdi.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:56 GMT -->
</html>
