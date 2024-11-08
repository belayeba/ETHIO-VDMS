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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Base UI</a></li>
                                        <li class="breadcrumb-item active">Embed Video</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Embed Video</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Responsive embed video 21:9</h4>
                                    <p class="text-muted mb-0">Use class <code>.ratio-21x9</code></p>
                                </div>
                                <div class="card-body">
                                    <!-- 21:9 aspect ratio -->
                                    <div class="ratio ratio-21x9">
                                        <iframe
                                            src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0""></iframe>
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Responsive embed video 1:1</h4>
                                    <p class="text-muted mb-0">Use class <code>.ratio-1x1</code></p>
                                </div>
                                <div class="card-body">
                                    <!-- 1:1 aspect ratio -->
                                    <div class="ratio ratio-1x1">
                                        <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0""></iframe>
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Responsive embed video 16:9</h4>
                                    <p class="text-muted mb-0">Use class <code>.ratio-16x9</code></p>
                                </div>
                                <div class="card-body">
                                    <!-- 16:9 aspect ratio -->
                                    <div class="ratio ratio-16x9">
                                        <iframe
                                            src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0""></iframe>
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Responsive embed video 4:3</h4>
                                    <p class="text-muted mb-0">Use class <code>.ratio-4x3</code></p>
                                </div>
                                <div class="card-body">
                                    <!-- 4:3 aspect ratio -->
                                    <div class="ratio ratio-4x3">
                                        <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0""></iframe>
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
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

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/ui-embed-video.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:04 GMT -->
</html>