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
                                        <li class="breadcrumb-item active">Range Slider</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Range Slider</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Default</h4>
                                    <p class="text-muted mb-0">Start with default options</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_01" data-plugin="range-slider" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Prefix</h4>
                                    <p class="text-muted mb-0">Showing grid and adding prefix "$"</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_03" data-plugin="range-slider" data-type="double"
                                        data-grid="true" data-min="0" data-max="1000" data-from="200" data-to="800"
                                        data-prefix="$" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Step</h4>
                                    <p class="text-muted mb-0">Increment with specific value only (step)</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_05" data-plugin="range-slider" data-type="double"
                                        data-grid="true" data-min="-1000" data-max="1000" data-from="-500" data-to="500"
                                        data-step="250" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Prettify Numbers</h4>
                                    <p class="text-muted mb-0">Prettify enabled. Much better!</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_07" data-plugin="range-slider" data-grid="true"
                                        data-min="1000" data-max="1000000" data-step="1000" data-from="200000"
                                        data-to="1000" data-prettify_enabled="true" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Extra Example</h4>
                                    <p class="text-muted mb-0">Want to show that max number is not the biggest one?</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_09" data-plugin="range-slider" data-grid="true"
                                        data-min="18" data-max="70" data-prefix="Age" data-max_postfix="+"
                                        data-from="30" data-to="1000" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Postfixes</h4>
                                    <p class="text-muted mb-0">Using postfixes</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_11" data-plugin="range-slider" data-type="single"
                                        data-grid="true" data-min="-90" data-max="90" data-postfix=" Â°"
                                        data-from="0" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Min-Max</h4>
                                    <p class="text-muted mb-0">Set min value, max value and start point</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_02" data-plugin="range-slider" data-min="100"
                                        data-max="1000" data-from="550" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Range</h4>
                                    <p class="text-muted mb-0">Set up range with negative values</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_04" data-plugin="range-slider" data-min="-1000"
                                        data-max="1000" data-from="-500" data-to="500" data-type="double"
                                        data-grid="true" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Custom Values</h4>
                                    <p class="text-muted mb-0">Using any strings as values</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_06" data-plugin="range-slider" data-grid="true"
                                        data-from="3" data-values='Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec' />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Disabled</h4>
                                    <p class="text-muted mb-0">Lock slider by using disable option</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_08" data-plugin="range-slider" data-min="100"
                                        data-max="1000" data-from="550" data-disable="true" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Use Decorate Both option</h4>
                                    <p class="text-muted mb-0">Use decorate_both option</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_10" data-plugin="range-slider" data-type="double"
                                        data-min="100" data-max="200" data-from="145" data-to="155"
                                        data-prefix="Weight " data-postfix=" million pounds"
                                        data-decorate_both="true" />
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Hide</h4>
                                    <p class="text-muted mb-0">Or hide any part you wish</p>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="range_12" data-plugin="range-slider" data-type="double"
                                        data-min="1000" data-max="2000" data-from="1200" data-to="1800"
                                        data-hide_min_max="true" data-hide_from_to="true" data-grid="true" />
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

    <!-- Plgins only -->
    <script src="assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="assets/js/pages/range-slider.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/extended-range-slider.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:09 GMT -->
</html>