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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active">Editors</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Editors</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Quill Editor</h4>
                                    <p class="text-muted mb-0">Snow is a clean, flat toolbar theme.</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="mb-2">
                                            <div id="snow-editor" style="height: 300px;">
                                                <h3><span class="ql-size-large">Hello World!</span></h3>
                                                <p><br></p>
                                                <h3>This is an simple editable area.</h3>
                                                <p><br></p>
                                                <ul>
                                                    <li>
                                                        Select a text to reveal the toolbar.
                                                    </li>
                                                    <li>
                                                        Edit rich document on-the-fly, so elastic!
                                                    </li>
                                                </ul>
                                                <p><br></p>
                                                <p>
                                                    End of simple area
                                                </p>
                                            </div><!-- end Snow-editor-->
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-1">Bubble Editor</h5>
                                    <p class="text-muted mb-0">Bubble is a simple tooltip based theme.</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="mb-2">
                                            <div id="bubble-editor" style="height: 300px;">
                                                <h3><span class="ql-size-large">Hello World!</span></h3>
                                                <p><br></p>
                                                <h3>This is an simple editable area.</h3>
                                                <p><br></p>
                                                <ul>
                                                    <li>
                                                        Select a text to reveal the toolbar.
                                                    </li>
                                                    <li>
                                                        Edit rich document on-the-fly, so elastic!
                                                    </li>
                                                </ul>
                                                <p><br></p>
                                                <p>
                                                    End of simple area
                                                </p>
                                            </div> <!-- end Snow-editor-->

                                        </div>
                                    </li>
                                </ul> <!-- end list-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
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

    <!-- Quill Editor js -->
    <script src="assets/vendor/quill/quill.min.js"></script>

    <!-- Quill Demo js -->
    <script src="assets/js/pages/quilljs.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/form-editors.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:23 GMT -->
</html>