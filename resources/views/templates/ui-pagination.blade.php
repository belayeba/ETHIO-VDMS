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
                                            <li class="breadcrumb-item active">Pagination</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Pagination</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Default Pagination</h4>
                                        <p class="text-muted mb-0">Simple pagination inspired by Rdio, great for apps and search results.</p>
                                    </div>
                                    <div class="card-body">
                                        <nav>
                                            <ul class="pagination mb-0">
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Disabled and active states</h4>
                                        <p class="text-muted mb-0">Pagination links are customizable for different circumstances. Use <code>.disabled</code> for links that appear un-clickable and <code>.active</code> to indicate the current page.</p>
                                    </div>
                                    <div class="card-body">
                                        <nav aria-label="...">
                                            <ul class="pagination mb-0">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item active" aria-current="page">
                                                    <a class="page-link" href="#">2</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </nav> 
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Alignment</h4>
                                        <p class="text-muted mb-0">Change the alignment of pagination components with flexbox utilities.</p>
                                    </div>
                                    <div class="card-body">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="javascript: void(0);" tabindex="-1">Previous</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);">Next</a>
                                                </li>
                                            </ul>
                                        </nav>

                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-end">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="javascript: void(0);" tabindex="-1">Previous</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Rounded Pagination</h4>
                                        <p class="text-muted mb-0">Add <code> .pagination-rounded</code> for rounded pagination.</p>
                                    </div>
                                    <div class="card-body">
                                        <nav>
                                            <ul class="pagination pagination-rounded mb-0">
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                                <li class="page-item active"><a class="page-link" href="javascript: void(0);">3</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Sizing</h4>
                                        <p class="text-muted mb-0">Add <code> .pagination-lg</code> or <code> .pagination-sm</code> for additional sizes.</p>
                                    </div>
                                    <div class="card-body">
                                        <nav>
                                            <ul class="pagination pagination-lg">
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>

                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
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

<!-- Mirrored from techzaa.getappui.com/velonic/layouts/ui-pagination.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:07 GMT -->
</html>
