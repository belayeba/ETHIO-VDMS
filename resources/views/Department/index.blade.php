@extends('layouts.navigation')
@section('content')

<div class="wrapper">
    <div class="content-page">
       @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" 
                role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Error - </strong> {!! session('error_message') !!}
            </div>
            @endif
            
            @if(Session::has('success_message'))
            <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5"
                role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong> Success- </strong> {!! session('success_message') !!} 
            </div>
            @endif
        <div class="preloader" dir="ltr">
            <!-- Preloader HTML here -->
        </div>
        <input type="hidden" name="table_name" id="table_name" value="">
        <input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">

        <div class="main-wrapper" style="min-height: 600px">
            <!-- Page Content  -->
            <div id="main-content" class="">
                <section class="sms-breadcrumb mb-10 white-box">
                    <div class="container-fluid p-0">
                        {{-- <div class="d-flex flex-wrap justify-content-between">
                            <h2 class="text">Department</h2>
                            <div class="bc-pages">
                                <!-- Breadcrumbs HTML here -->
                            </div>
                        </div> --}}
                    </div>
                </section>

                <section class="admin-visitor-area up_st_admin_visitor">
                    <div class="container-fluid p-0">
                        <div class="row justify-content-center">
                            <!-- Add New Department Form -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title mb-0">New Department</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('department.store') }}" accept-charset="UTF-8" name="department-form" id="department-form" enctype="multipart/form-data">
                                            @csrf

                                            <div class="col-mb-3 form-group {{ $errors->has('cluster') ? 'has-error' : '' }}">
                                                <label for="cluster" class=" control-label">Cluster</label>
                                                    
                                                <select class="form-control select" id="cluster_id" name="cluster_id" data-fouc required>
                                                    <option value="">Select Cluster</option>
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
                                        <h4 class="header-title mb-0">Department List</h4>
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
                                                            <form method="POST" action="{{ route('department.destroy', $item) }}" accept-charset="UTF-8">
                                                                @method('DELETE')
                                                                <input name="_method" value="DELETE" type="hidden">
                                                                {{ csrf_field() }}

                                                                <a type="button" class="btn btn-secondary rounded-pill"
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#department_modal_{{$loop->index}}"
                                                                        data-department-id="{{ $item->id }}"
                                                                        data-cluster-name="{{ $item->cluster->name }}"
                                                                        data-department-name="{{ $item->name }}">
                                                                        <i class="ri-edit-line"></i>
                                                            </a>

                                                                <button type="button" class="btn btn-danger rounded-pill" title="Delete Department"
                                                                data-bs-toggle="modal" data-bs-target="#warning_alert">
                                                                    <i class="ri-close-circle-line"></i> 
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>

                                                    <!-- Edit Department Modal -->
                                                    <div id="department_modal_{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <form method="POST" action="{{ route('department.update', $item) }}" class="ps-3 pe-3">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="department_id" value="{{ $item->id }}">
                                                    
                                                                        <div class="mb-3">
                                                                            <label for="cluster_id" class="form-label">Cluster</label>
                                                                            <select id="cluster_id" name="cluster_id" class="form-select" required>
                                                                                @foreach($departments as $department)
                                                                                    <option value="{{ $department->cluster_id }}" {{ $item->cluster_id == $department->cluster_id ? 'selected' : '' }}>
                                                                                        {{ $department->cluster->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                    
                                                                        <div class="mb-3">
                                                                            <label for="name" class="form-label">Name</label>
                                                                            <input class="form-control" type="text" name="name" id="department_name_{{$loop->index}}" value="{{ $item->name }}">
                                                                        </div>
                                                    
                                                                        <div class="mb-3 text-center">
                                                                            <button class="btn btn-primary" type="submit">Update</button>
                                                                            <a type="button" href="{{ route('department.index') }}" class="btn btn-warning">Cancel</a>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Accept Alert Modal -->
                                        <div id="warning_alert" class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                        aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('department.destroy',$item) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="request_id" id="request_id">
                                                    <div class="modal-body p-4">
                                                        <div class="text-center">
                                                            <i class="ri-alert-line h1 text-warning"></i>
                                                            <h4 class="mt-2">Warning</h4>
                                                            <h5 class="mt-3">
                                                                Are you sure you want to delete this department?</br> This action
                                                                cannot be
                                                                undone.
                                                            </h5>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                id="confirmDelete">Yes,
                                                                Accept</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
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
                                <p class="text-center">Are you sure to delete?</p>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <a id="delete_link" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-department-btn');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var clusterName = this.getAttribute('data-cluster-name');
                var departmentName = this.getAttribute('data-department-name');
                var index = this.getAttribute('data-bs-target').split('_').pop();

                // Populate the modal input field with the selected department's name
                document.getElementById('cluster_name_' + index).value = clusterName;
                document.getElementById('department_name_' + index).value = departmentName;
            });
        });
    });
</script>

<script src="backend/js/datatable_extra.js"></script>
<script src="backend/js/plugin.js"></script>
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
