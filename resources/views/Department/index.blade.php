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
                                <h2 class="text-uppercase">Department</h2>
                                <div class="bc-pages">
                                    {{-- <a href="../dashboard.html">Dashboard</a>
                                    <a href="#">Organization</a>
                                    <a href="ebook.html">Department</a> --}}
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="admin-visitor-area up_st_admin_visitor">
                        <div class="container-fluid p-0">
                            <div class="row justify-content-center">
                                <!-- Add New Department Form -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">New Department</h3>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('department.store') }}" accept-charset="UTF-8" name="ebook-form" id="ebook-form" enctype="multipart/form-data">
                                                @csrf
                                                {{-- <div class="card-body"> --}}
                                                    {{-- <div class="row"> --}}
                                                        <div class="col-md-8 form-group {{ $errors->has('cluster') ? 'has-error' : '' }}">
                                                            <label for="cluster" class=" control-label">Cluster</label>
                                                                
                                                                    <select data-placeholder = "{{ 'Select Cluster' }}" value="cluster"  class="form-control select" id="cluster_id" name="cluster_id" data-fouc required="true">
                                                                        <option style="display: none;"> </option>
                                                                        @foreach ($clusters as $item)
                                                                        
                                                                        <option value="{{ $item->cluster_id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                        
                                                                
                                                                {!! $errors->first('cluster', '<p class="help-block">:message</p>') !!}
                                                            
                                                        </div>
                                                <div class="mb-3">
                                                    <label for="nameInput" class="form-label">Name <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" id="nameInput" name="name" placeholder="Name">
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Department List -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Department List</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lms_table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Cluster</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($departments as $item)
                                                        <tr>
                                                        <!-- Table rows will be populated here -->
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->cluster->name }}</td>
                                                        <td>
                                                            <form method="POST" action=""accept-charset="UTF-8">
                                                                <input name="_method" value="DELETE" type="hidden">
                                                                {{ csrf_field() }}
                                                                  <a href=""
                                                                    class="btn btn-outline-warning btn-sm" title="Edit Department">
                                                                    Edit
                                                                  </a>
                                        
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Department"
                                                               onclick="return confirm(&quot;Click OK to delete Department.&quot;)">
                                                               Delete
                                                            </button>
                                                          </form>
                                                         </td> 
                                                        </tr>
                                                        @endforeach
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