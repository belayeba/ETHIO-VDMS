{{-- @include('common.adminhead') --}}
<!DOCTYPE html>
<html lang="en">
@include('layouts.main-link')
@include('layouts.header')
@include('layouts.sidebar')
@include('layouts.setting')

<body class="admin">
    <div class="wrapper">
        <div class="content-page">
            <div class="preloader" dir="ltr">
                <div class='body'>
                    <span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <div class='base'>
                        <span></span>
                        <div class='face'></div>
                    </div>
                </div>
                <div class='longfazers'>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <input type="hidden" name="demoMode" id="demoMode" value="1">
            <input type="hidden" name="url" id="url" value="https://E-LearningPortal.com">
            <input type="hidden" name="active_date_format" id="active_date_format" value="jS M, Y">
            <input type="hidden" name="js_active_date_format" id="js_active_date_format" value="mm/dd/yyyy">
            <input type="hidden" name="table_name" id="table_name" value="">
            <input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">
            <input type="hidden" name="currency_symbol" class="currency_symbol" value="$">
            <input type="hidden" name="currency_show" class="currency_show" value="1">
            <input type="hidden" name="chat_settings" id="chat_settings" value="">

            <div class="main-wrapper" style="min-height: 600px">
                <!-- Page Content  -->
                <div id="main-content" class="">
                    <section class="sms-breadcrumb mb-10 white-box">
                        <div class="container-fluid p-0">
                            <div class="d-flex flex-wrap justify-content-between">
                                <h2 class="text-uppercase">Vehicle</h2>
                                <div class="bc-pages">
                                    <a href="../dashboard.html">Dashboard</a>
                                    <a href="#">Organization</a>
                                    <a href="ebook.html">Maintenance</a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="admin-visitor-area up_st_admin_visitor">
                        <div class="container-fluid p-0">
                            <div class="row justify-content-center">
                                <!-- Add New Ebook Form -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">New Vehicle Registration</h3>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="" accept-charset="UTF-8" name="ebook-form" id="ebook-form" enctype="multipart/form-data">
                                                @csrf
                                                {{-- <div class="card-body">  --}}
                                                     {{-- <div class="row"> --}}
                                                       
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">Vin <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="vinInput" name="vin" placeholder="Enter the vin ...">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="modelInput" class="form-label">Model <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="modelInput" name="model" placeholder="Enter the model here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="makeInput" class="form-label">Make <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="makeInput" name="make" placeholder="Enter the make here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="yearInput" class="form-label">Year <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="yearInput" name="year" placeholder="Enter the year here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="plateInput" class="form-label">Plate <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="plateInput" name="plate" placeholder="Enter the plate here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="milageInput" class="form-label">Milage <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="milageInput" name="milage" placeholder="Enter the milage here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="vehicleTypeInput" class="form-label">Vehicle Type <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="vehicleTypeInput" name="vehicleType" placeholder="Enter the vehicle type here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="vehicleCategoryInput" class="form-label">Vehicle Category <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="vehicleCategoryInput" name="vehicleCategory" placeholder="Enter the vehicle category here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fuelAmountInput" class="form-label">Fuel Amount<strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="fuelAmountInput" name="fuelAmount" placeholder="Enter the fuel amount here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="lastServiceInput" class="form-label">Last Service<strong class="text-danger">*</strong></label>
                                                    <input type="date" class="form-control" id="lastServiceInput" name="lastService" placeholder="Enter the last service date here">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nextServiceInput" class="form-label">Next Service<strong class="text-danger">*</strong></label>
                                                    <input type="date" class="form-control" id="nextServiceInput" name="nextService" placeholder="Enter the next service date here">
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <label for="dropdownMenuButton">FUEL TYPE<strong class="text-danger">*</strong></label>
                                                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 300px">
                                                           --Choose--
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="#">Benzene</a>
                                                            <a class="dropdown-item" href="#">Petrol</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Request</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Ebook List -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Maintenance List</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lms_table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Maintenance Type</th>
                                                            <th scope="col">Description</th>
                                                            <th scope="col">Status</th>
                                                            {{-- <th scope="col">Action</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Table rows will be populated here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteLabel">Delete Confirmation</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Are you sure to delete ?</p>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <a id="delete_link" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="footer-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center mt-5">
                                    <p class="p-3 mb-0">Copyright © 2024. All rights reserved | Made By Ai</p>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <script src="backend/js/datatable_extra.js"></script>
    <script src="backend/js/plugin.js"></script>
    <script src="chat/js/custom7b4a.js?v=7.1.0"></script>
    <script src="whatsapp-support/scripts7b4a.js?v=7.1.0"></script>
    <script src="vendor/uppy/uppy.min.js"></script>
    <script src="vendor/uppy/uppy.legacy.min.js"></script>
    <script src="vendor/uppy/ru_RU.min.js"></script>
    <script src="../Modules/AIContent/Resources/assets/js/ai_content.js"></script>
    <script>
        $(document).on('click', '#show_ai_text_generator', function () {
            var selected_template = $(this).data('selected_template');
            var ai_template = $('#ai_template');
            if (selected_template) {
                ai_template.val(selected_template);
                $('#ai_template').niceSelect('update');
            }
            $("#ai_text_generation_modal").modal('show');
        });

        $(document).on('change', '#ai_template', function (e) {
            let templateId = $(this).val();
            if (templateId == 1 || templateId == 11) {
                $('#titleDiv').addClass('d-none');
            } else {
                $('#titleDiv').removeClass('d-none');
            }
        });

        $('.dataTables_length label select').niceSelect();
        $('.dataTables_length label .nice-select').addClass('dataTable_select');
        $(document).on('click', '.dataTables_length label .nice-select', function () {
            $(this).toggleClass('open_selectlist');
        });
    </script>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
</body>
</html>
