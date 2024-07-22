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
                                            <li class="breadcrumb-item active">Breadcrumb</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Breadcrumb</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">  
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Example</h4>
                                        <p class="text-muted mb-0">
                                            Indicate the current page’s location within a navigational hierarchy that automatically adds separators via CSS.
                                            Please read the official <a target="_blank" href="https://getbootstrap.com/docs/5.3/components/breadcrumb/">Bootstrap</a> documentation for more options.
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0 py-2">
                                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                                            </ol>
                                        </nav>
                                            
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0 py-2">
                                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                                            </ol>
                                        </nav>
                                            
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0 py-2">
                                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Data</li>
                                            </ol>
                                        </nav>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                            <div class="col-12">  
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">With Icons</h4>
                                        <p class="text-muted mb-0">
                                            Optionally you can also specify the icon with your breadcrumb item.
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-1 p-2 bg-light-subtle">
                                                <li class="breadcrumb-item active" aria-current="page"><i class="ri-home-4-line me-1"></i>Home</li>
                                            </ol>
                                        </nav>
                                            
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-1 p-2 bg-light-subtle">
                                                <li class="breadcrumb-item"><a href="#"><i class="ri-home-4-line"></i> Home</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                                            </ol>
                                        </nav>
                                            
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0 p-2 bg-light-subtle">
                                                <li class="breadcrumb-item"><a href="#"><i class="ri-home-4-line"></i> Home</a></li>
                                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Data</li>
                                            </ol>
                                        </nav>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                        </div> <!-- end row -->
                        
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

<!-- Mirrored from techzaa.getappui.com/velonic/layouts/ui-breadcrumb.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:04 GMT -->
</html>
