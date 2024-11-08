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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Basic Tables</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Basic Tables</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Cluster</h4>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#cluster_modal">Add New</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-sm">
                                        <table class="table table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                    {{-- <th>Phone Number</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cluster as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div> <!-- end table-responsive-->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->

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
        <div id="cluster_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="{{ route('cluster.store') }}" method="POST" class="ps-3 pe-3">
                            @csrf <!-- Add CSRF token field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" name="name" id="name" required placeholder="John">
                            </div>
        
                            <div class="mb-3 text-center">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <a type="button" href="{{ route('cluster.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/tables-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:41 GMT -->
</html>