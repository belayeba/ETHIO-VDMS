@extends('layouts.navigation')

@section('content')
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
                                    <li class="breadcrumb-item active">Data Tables</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Data Tables</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Role Table</h4>
                            <div class="btn-group btn-group-sm pull-right" role="group">
                                <button type="button" class="btn btn-success"
                                    style="font-weight: italic; border-radius: 35px;" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class=" ri-add-fill"></i>
                                </button>
                            </div>
                        </div>

                        {{-- This the create role modal  --}}
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Role Create</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div> <!-- end modal header -->
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('roles.store') }}" accept-charset="UTF-8"
                                            id="create_role_form" name="create_role_form" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <strong>
                                                            <h4
                                                                style="color:#215467; font-weight: bold; font-family:serif;">
                                                                Role Name</h4>
                                                        </strong>
                                                        <input class="form-control" name="name" type="text"
                                                            id="name" value="" minlength="1" maxlength="255"
                                                            placeholder="Enter Role Name...">
                                                    </div>
                                                </div>
                                                </br></br></br></br>
                                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                                    <div class="form-group">
                                                        <strong>
                                                            <h4
                                                                style="color:#215467; font-weight: bold; font-family:serif;">
                                                                Permmisions</h4>
                                                        </strong>

                                                        @php

                                                            $groupedPermissions = $permission->groupBy('group_id');
                                                            $chunkedPermissions = $groupedPermissions->chunk(3);
                                                        @endphp

                                                        @foreach ($chunkedPermissions as $chunk)
                                                            <div class="row">
                                                                @foreach ($chunk as $groupedPermission)
                                                                    <div class="col-md-3">
                                                                        <div class="card"
                                                                            style="box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);">
                                                                            <div class="card-header ">
                                                                                <strong>{{ $groupedPermission->first()->PermissionGroup->name }}
                                                                                </strong>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                @foreach ($groupedPermission as $value)
                                                                                    <blockquote class="card-bodyquote">
                                                                                        <input type="checkbox"
                                                                                            id="{{ $value->id }}"
                                                                                            name="permission[]"
                                                                                            value="{{ $value->name }}">
                                                                                        <label for="permission"
                                                                                            style="color:#215467; font-size: 14px; font-family: system-ui;">{{ $value->name }}</label>
                                                                                    </blockquote>
                                                                                @endforeach
                                                                            </div> <!-- end card-body -->
                                                                        </div> <!-- end card -->
                                                                    </div> <!-- end col -->
                                                                @endforeach
                                                            </div> <!-- end row -->
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"style=" border-radius:25px"
                                            id="selectAllBtn" onclick="toggleCheckboxes()">select
                                            all</button>
                                        <button class="btn btn-primary" type="submit"
                                            style="border-radius: 25px;">create</button>
                                    </div> <!-- end modal footer -->
                                    </form>
                                </div> <!-- end modal content-->
                            </div> <!-- end modal dialog-->
                        </div>
                        <!-- end create modal-->



                        <div class="card-body">
                            @if (count($roles) == 0)
                                <div class="panel-body text-center">
                                    <h4>there is no role registerd.</h4>
                                </div>
                            @else
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ROll</th>
                                            <th>Name</th>
                                            <th>Permmission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td style="color: black;  font-family:system-ui">{{ ++$i }}</td>
                                                <td style="color: black;  font-family:system-ui">{{ $role->name }}</td>
                                                <td style="color: black;  font-family:system-ui">
                                                    @if (!empty($rolePermissions))
                                                        @foreach ($rolePermissions as $v)
                                                            @if ($v->role_id == $role->id)
                                                                {{ $v->name }},
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td style=" text-align:center;">

                                                    <form method="POST" action="{!! route('roles.destroy', $role->id) !!}"
                                                        accept-charset="UTF-8">
                                                        <input name="_method" value="DELETE" type="hidden">
                                                        {{ csrf_field() }}

                                                        <div class="btn-group btn-group-xs pull-right" role="group">

                                                            <a href="{{ route('roles.show', $role->id) }}"
                                                                class="btn btn-info" title="Show"><i
                                                                    class="ri-eye-fill"></i></a>


                                                            @if ($role->name !== 'Admin')
                                                                <a href="{{ route('roles.edit', $role->id) }}"
                                                                    class="btn btn-primary" title="Edit"><i
                                                                        class=" ri-edit-fill"></i> </a>




                                                                <button type="submit" class="btn btn-danger"
                                                                    title="Delete"
                                                                    onclick="return confirm(&quot;Are you sure you want to delete?&quot;)">
                                                                    <i class="ri-delete-bin-7-fill"></i>
                                                                </button>
                                                            @endif

                                                        </div>

                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>


                        </div> <!-- end row-->
                        {!! $roles->render() !!}
                        @endif

                    </div> <!-- end col -->
                    <script>
                        function toggleCheckboxes() {
                            var checkboxes = document.querySelectorAll('input[name="permission[]"]');
                            var selectAllBtn = document.getElementById('selectAllBtn');
                            var checked = false;

                            checkboxes.forEach(function(checkbox) {
                                if (checkbox.checked) {
                                    checked = true;
                                    return;
                                }
                            });

                            checkboxes.forEach(function(checkbox) {
                                checkbox.checked = !checked;
                            });

                            if (checked) {
                                selectAllBtn.textContent = 'sellect all';
                            } else {
                                selectAllBtn.textContent = 'deselect all';
                            }
                        }
                    </script>
                @endsection
