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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Charts</a></li>
                                        <li class="breadcrumb-item active">Sparkline</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Sparkline</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Line Charts</h4>
                                    <div class="mt-4">
                                        <div id="sparkline1" data-colors="#3bc0c3,#4489e4"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Bar Chart</h4>
                                    <div class="mt-4">
                                        <div id="sparkline2" data-colors="#3bc0c3" class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Pie Chart</h4>
                                    <div class="mt-4">
                                        <div id="sparkline3" data-colors="#3bc0c3,#4489e4,#d03f3f,#716cb0"
                                            class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Custom Line Chart</h4>
                                    <div class="mt-4">
                                        <div id="sparkline4" data-colors="#3bc0c3,#716cb0" class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Mouse Speed Chart</h4>
                                    <div class="mt-4">
                                        <div id="sparkline5" data-colors="#716cb0" class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Composite bar Chart</h4>
                                    <div class="text-center mt-4">
                                        <div id="sparkline6" data-colors="#f2f2f7,#3bc0c3" class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Discrete Chart</h4>
                                    <div class="text-center mt-4">
                                        <div id="sparkline7" data-colors="#33b0e0" class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Bullet Chart</h4>
                                    <div class="text-center mt-4" style="min-height: 164px;">
                                        <div id="sparkline8" data-colors="#f24f7c,#4489e4" class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Box Plot Chart</h4>
                                    <div class="text-center mt-4" style="min-height: 164px;">
                                        <div id="sparkline9" data-colors="#3bc0c3,#1a2942,#d1d7d973" class="text-center"></div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Tristate Charts</h4>
                                    <div class="text-center mt-4" style="min-height: 164px;">
                                        <div id="sparkline10" data-colors="#d1d7d973,#1a2942,#3bc0c3" class="text-center">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div> <!-- end col -->

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

    <!-- Chart.js js -->
    <script src="assets/vendor/chart.js/chart.min.js"></script>

  <!-- Sparkline charts -->
  <script src="assets/vendor/jquery-sparkline/jquery.sparkline.min.js"></script>

  <!-- init js -->
  <script src="assets/js/pages/sparkline.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/charts-sparklines.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:40 GMT -->
</html>