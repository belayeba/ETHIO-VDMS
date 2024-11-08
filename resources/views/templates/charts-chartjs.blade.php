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
                                            <li class="breadcrumb-item active">Chartjs</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Chartjs</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Boundaries</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="boundaries-example" data-colors="#3bc0c3,#47ad77"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Different Dataset</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="dataset-example"
                                                    data-colors="#3bc0c3,#4489e4,#d03f3f,#716cb0, #f24f7c"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Border Radius</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="border-radius-example" data-colors="#3bc0c3,#4489e4"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Floating</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="floating-example" data-colors="#3bc0c3,#4489e4"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Interpolation</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="interpolation-example" data-colors="#4489e4,#3bc0c3"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Line</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="line-example" data-colors="#4489e4,#d03f3f"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">Bubble</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="bubble-example" data-colors="#716cb0,#d03f3f"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-4">DONUT</h4>

                                        <div dir="ltr">
                                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                                <canvas id="donut-example" data-colors="#3bc0c3,#4489e4,#d03f3f,#716cb0"></canvas>
                                            </div>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

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

        <!-- Chart.js Area Demo js -->
        <script src="assets/js/pages/chartjs-area.init.js"></script>
        <!-- Chart.js Bar Demo js -->
        <script src="assets/js/pages/chartjs-bar.init.js"></script>
        <!-- Chart.js Line Demo js -->
        <script src="assets/js/pages/chartjs-line.init.js"></script>
        <!-- Chart.js Other Demo js -->
        <script src="assets/js/pages/chartjs-other.init.js"></script> 

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/charts-chartjs.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:38 GMT -->
</html>