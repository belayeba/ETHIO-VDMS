@extends('layouts.navigation')

@section('content')

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
            <input type="hidden" name="table_name" id="table_name" value="">
            <input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">

            <div class="main-wrapper" style="min-height: 600px">
                <!-- Page Content  -->
                <div id="main-content" class="">
                    <section class="sms-breadcrumb mb-10 white-box">
                        <div class="container-fluid p-0">
                            <div class="d-flex flex-wrap justify-content-between">
                               
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
                                            <h4 class="header-title mb-0">New Maintenance</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="" accept-charset="UTF-8" name="ebook-form" id="ebook-form" enctype="multipart/form-data">
                                                @csrf
                                                {{-- <div class="card-body"> --}}
                                                    {{-- <div class="row"> --}}
                                                        <div class="col-auto">
                                                            <div class="position-relative mb-3">
                                                                <div class="position-relative mb-3">
                                                                    <label class="form-label" for="validationTooltip02">Select Vehicle</label>
                                                                    <select class="form-control" id="department_id" name="vehicle_id">
                                                                            <option value=""   disabled selected>Select</option>
                                                                            @foreach ($vehicle as $vec )
                                                                            <option value="{{$vec->vehicle_id}}">
                                                                                {{$vec->plate_number}}
                                                                            </option>
                                                                            @endforeach
                                                                    </select>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">Name <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="nameInput" name="name" placeholder="Name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">Description <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="nameInput" name="description" placeholder="Write your description here">
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
                                            <h4 class="header-title mb-0">Maintenance List</h4>
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
@endsection
