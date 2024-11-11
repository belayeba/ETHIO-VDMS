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
                          
                        </div>
                    </section>

                    <section class="admin-visitor-area up_st_admin_visitor">
                        <div class="container-fluid p-0">
                            <div class="row justify-content-center">
                                <!-- Add New Cluster Form -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title mb-0">New Cluster</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('cluster.store') }}" accept-charset="UTF-8" name="cluster-form" id="cluster-form" enctype="multipart/form-data">
                                                @csrf
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
                                
                                <!-- Cluster List -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="header-title mb-0">Cluster List</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lms_table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th> {{' # '}} </th>
                                                            <th>{{ 'Name' }}</th>
                                                            <th>{{ 'Action' }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($clusters as $item)
                                                        <tr>
                                                        <!-- Table rows will be populated here -->
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>
                                                            <form method="POST" action=" "accept-charset="UTF-8">
                                                                @method('DELETE')
                                                                <input name="_method" value="DELETE" type="hidden">
                                                                {{ csrf_field() }}
                                                                    <a type="button" class="btn btn-secondary rounded-pill"  
                                                                            data-bs-toggle="modal" 
                                                                            data-bs-target="#cluster_modal_{{$loop->index}}"
                                                                            data-cluster-id="{{ $item->id }}"
                                                                            data-cluster-name="{{ $item->name }}">
                                                                            <i class="ri-edit-line"></i>
                                                                    </a>
 
                                                            <button type="button" class="btn btn-danger rounded-pill" title="Delete Cluster"
                                                               data-bs-toggle="modal" data-bs-target="#warning_alert">
                                                                <i class="ri-close-circle-line"></i>
                                                            </button>
                                                          </form>
                                                         </td> 
                                                        </tr>
                                                          <div id="cluster_modal_{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <form method="POST" action="{{ route('cluster.update',$item) }}" class="ps-3 pe-3">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <input type="hidden" name="cluster_id" value="{{ $item->cluster_id }}">

                                                                            <div class="mb-3">
                                                                                <label for="name" class="form-label">Name</label>
                                                                                <input class="form-control" type="text" name="name" id="name" value="{{ $item->name }}">
                                                                            </div>
                                                                        
                                                                            <div class="mb-3 text-center">
                                                                                <button class="btn btn-primary" type="submit">Update</button>
                                                                                <a type="button" href="{{ route('cluster.index') }}" class="btn btn-warning">Cancel</a>
                                                                            </div>
                                                                         </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <!-- Accept Alert Modal -->
                                                <div id="warning_alert" class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                                aria-labelledby="confirmationModalLabel"aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('cluster.destroy',$item) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="request_id" id="request_id">
                                                            <div class="modal-body p-4">
                                                                <div class="text-center">
                                                                    <i class="ri-alert-line h1 text-warning"></i>
                                                                    <h4 class="mt-2">Warning</h4>
                                                                    <h5 class="mt-3">
                                                                        Are you sure you want to delete this cluster?</br> This action
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

                   <style>
                    @media only screen and (max-width: 768px) {
    .col-md-4 {
        width: 100%;
    }

    .col-md-8 {
        width: 100%;
    }

    .card {
        margin-bottom: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .modal-dialog {
        max-width: 90%;
    }
}

@media only screen and (max-width: 480px) {
    .card {
        padding: 10px;
    }

    .modal-dialog {
        max-width: 100%;
    }
}
                   </style>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var editButtons = document.querySelectorAll('.edit-cluster-btn');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var cluster = this.getAttribute('data-cluster');
            var clusterId = this.getAttribute('data-cluster-id');
            var clusterName = this.getAttribute('data-cluster-name');

            // Update the form action to include the correct cluster ID (if needed)
            var form = document.querySelector('#cluster_modal form');
            // form.action = '/cluster/update' + cluster;  // Adjust this route to your actual update route

            // Populate the modal input field with the selected cluster's name
            document.getElementById('name').value = clusterName;
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
