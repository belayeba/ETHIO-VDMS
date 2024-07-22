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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Extended UI</a></li>
                                        <li class="breadcrumb-item active">Scrollbar</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Scrollbar</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Default Scroll</h4>
                                    <p class="text-muted mb-0">Just use data attribute <code>data-simplebar</code>
                                        and add <code>max-height: **px</code> oh fix height</p>
                                </div>

                                <div class="card-body py-0 my-3" data-simplebar style="max-height: 250px;">
                                    SimpleBar does only one thing: replace the browser's default scrollbar
                                    with a custom CSS-styled one without losing performances.
                                    Unlike some popular plugins, SimpleBar doesn't mimic scroll with
                                    Javascript, causing janks and strange scrolling behaviours...
                                    You keep the awesomeness of native scrolling...with a custom scrollbar!
                                    <p>SimpleBar <strong>does NOT implement a custom scroll
                                            behaviour</strong>. It keeps the <strong>native</strong>
                                        <code>overflow: auto</code> scroll and <strong>only</strong> replace
                                        the scrollbar visual appearance.
                                    </p>
                                    <h5>Design it as you want</h5>
                                    <p>SimpleBar uses pure CSS to style the scrollbar. You can easily
                                        customize it as you want! Or even have multiple style on the same
                                        page...or just keep the default style ("Mac OS" scrollbar style).
                                    </p>
                                    <h5>Lightweight and performant</h5>
                                    <p>Only 6kb minified. SimpleBar doesn't use Javascript to handle
                                        scrolling. You keep the performances/behaviours of the native
                                        scroll.</p>
                                    <h5>Supported everywhere</h5>
                                    <p class="mb-0">SimpleBar has been tested on the following browsers: Chrome,
                                        Firefox,
                                        Safari, Edge, IE11.</p>
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">RTL Position</h4>
                                    <p class="text-muted mb-0">Just use data attribute
                                        <code>data-simplebar data-simplebar-direction='rtl'</code>
                                        and add <code>max-height: **px</code> oh fix height
                                    </p>
                                </div>

                                <div class="card-body py-0 my-3" data-simplebar data-simplebar-direction='rtl'
                                    style="max-height: 250px;">
                                    SimpleBar does only one thing: replace the browser's default scrollbar
                                    with a custom CSS-styled one without losing performances.
                                    Unlike some popular plugins, SimpleBar doesn't mimic scroll with
                                    Javascript, causing janks and strange scrolling behaviours...
                                    You keep the awesomeness of native scrolling...with a custom scrollbar!
                                    <p>SimpleBar <strong>does NOT implement a custom scroll
                                            behaviour</strong>. It keeps the <strong>native</strong>
                                        <code>overflow: auto</code> scroll and <strong>only</strong> replace
                                        the scrollbar visual appearance.
                                    </p>
                                    <h5>Design it as you want</h5>
                                    <p>SimpleBar uses pure CSS to style the scrollbar. You can easily
                                        customize it as you want! Or even have multiple style on the same
                                        page...or just keep the default style ("Mac OS" scrollbar style).
                                    </p>
                                    <h5>Lightweight and performant</h5>
                                    <p>Only 6kb minified. SimpleBar doesn't use Javascript to handle
                                        scrolling. You keep the performances/behaviours of the native
                                        scroll.</p>
                                    <h5>Supported everywhere</h5>
                                    <p class="mb-0">SimpleBar has been tested on the following browsers: Chrome,
                                        Firefox,
                                        Safari, Edge, IE11.</p>
                                </div><!-- end card-body -->

                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Scroll Size</h4>
                                    <p class="text-muted mb-0">Just use data attribute <code>data-simplebar</code>
                                        and add <code>max-height: **px</code> oh fix height</p>
                                </div>

                                <div class="card-body py-0 my-3" data-simplebar data-simplebar-lg
                                    style="max-height: 250px;">
                                    SimpleBar does only one thing: replace the browser's default scrollbar
                                    with a custom CSS-styled one without losing performances.
                                    Unlike some popular plugins, SimpleBar doesn't mimic scroll with
                                    Javascript, causing janks and strange scrolling behaviours...
                                    You keep the awesomeness of native scrolling...with a custom scrollbar!
                                    <p>SimpleBar <strong>does NOT implement a custom scroll
                                            behaviour</strong>. It keeps the <strong>native</strong>
                                        <code>overflow: auto</code> scroll and <strong>only</strong> replace
                                        the scrollbar visual appearance.
                                    </p>
                                    <h5>Design it as you want</h5>
                                    <p>SimpleBar uses pure CSS to style the scrollbar. You can easily
                                        customize it as you want! Or even have multiple style on the same
                                        page...or just keep the default style ("Mac OS" scrollbar style).
                                    </p>
                                    <h5>Lightweight and performant</h5>
                                    <p>Only 6kb minified. SimpleBar doesn't use Javascript to handle
                                        scrolling. You keep the performances/behaviours of the native
                                        scroll.</p>
                                    <h5>Supported everywhere</h5>
                                    <p class="mb-0">SimpleBar has been tested on the following browsers: Chrome,
                                        Firefox,
                                        Safari, Edge, IE11.</p>
                                </div><!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Scroll Color</h4>
                                    <p class="text-muted mb-0">Just use data attribute
                                        <code>data-simplebar data-simplebar-primary</code>
                                        and add <code>max-height: **px</code> oh fix height
                                    </p>
                                </div>
                                <div class="card-body py-0 my-3" data-simplebar data-simplebar-primary
                                    style="max-height: 250px;">
                                    SimpleBar does only one thing: replace the browser's default scrollbar
                                    with a custom CSS-styled one without losing performances.
                                    Unlike some popular plugins, SimpleBar doesn't mimic scroll with
                                    Javascript, causing janks and strange scrolling behaviours...
                                    You keep the awesomeness of native scrolling...with a custom scrollbar!
                                    <p>SimpleBar <strong>does NOT implement a custom scroll
                                            behaviour</strong>. It keeps the <strong>native</strong>
                                        <code>overflow: auto</code> scroll and <strong>only</strong> replace
                                        the scrollbar visual appearance.
                                    </p>
                                    <h5>Design it as you want</h5>
                                    <p>SimpleBar uses pure CSS to style the scrollbar. You can easily
                                        customize it as you want! Or even have multiple style on the same
                                        page...or just keep the default style ("Mac OS" scrollbar style).
                                    </p>
                                    <h5>Lightweight and performant</h5>
                                    <p>Only 6kb minified. SimpleBar doesn't use Javascript to handle
                                        scrolling. You keep the performances/behaviours of the native
                                        scroll.</p>
                                    <h5>Supported everywhere</h5>
                                    <p class="mb-0">SimpleBar has been tested on the following browsers: Chrome,
                                        Firefox,
                                        Safari, Edge, IE11.</p>
                                </div><!-- end card-body -->
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


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/extended-scrollbar.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:08 GMT -->
</html>