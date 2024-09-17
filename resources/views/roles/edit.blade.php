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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Base UI</a></li>
                                    <li class="breadcrumb-item active">Cards</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Cards</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-8 col-lg-3">

                        <!-- Simple card -->
                        <div class="card d-block">

                            <div class="card-body">
                                {{-- <div class="btn-group btn-group-sm pull-right" role="group">
                                    <a href="{{ route('roles.index') }}" class="btn btn-primary"
                                        style="border-radius: 25px;" title="የተመዘገቡ ሚናዎች">
                                        <i class="fas fa-list">List</i>
                                    </a>
                                </div> --}}
                                <div class="row">
                                    <div class="col-lg-12">

                                        @if ($errors->any())
                                            <ul class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif


                                        <form method="POST" action="{{ route('roles.update', $role->id) }}"
                                            id="edit_group_form" name="edit_group_form" accept-charset="UTF-8"
                                            class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input name="_method" type="hidden" value="PUT">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-lg-4">
                                                    <div class="form-group">
                                                        <strong>
                                                            <h4
                                                                style="color:#215467; font-weight: bold; font-family:serif;">
                                                                Name</h4>
                                                        </strong>
                                                        <input class="form-control" name="name" type="text"
                                                            id="name" value="{{ $role->name }}" minlength="1"
                                                            maxlength="255" placeholder="Enter name here...">

                                                    </div>
                                                </div>
                                                </br></br></br></br></br>
                                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                                    <div class="form-group">
                                                        <strong>
                                                            <h4
                                                                style="color:#215467; font-weight: bold; font-family:serif;">
                                                                Permission</h4>
                                                        </strong>
                                                        @php

                                                            $groupedPermissions = $permission->groupBy('group_id');
                                                            $chunkedPermissions = $groupedPermissions->chunk(3);
                                                        @endphp

                                                        @foreach ($chunkedPermissions as $chunk)
                                                            <div class="row">
                                                                @foreach ($chunk as $groupedPermission)
                                                                    <div class="col-md-3">
                                                                        <div class="card">
                                                                            <div class="card-header ">
                                                                                <strong>{{ $groupedPermission->first()->PermissionGroup->name }}
                                                                                </strong>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                @foreach ($groupedPermission as $value)
                                                                                    @if (in_array($value->id, $rolePermissions))
                                                                                        <blockquote class="card-bodyquote">
                                                                                            <input type="checkbox" checked
                                                                                                id="$value->id"
                                                                                                name="permission[]"
                                                                                                value="{{ $value->name }}">
                                                                                            <label for="permission"
                                                                                                style="color:#215467; font-size: 14px; font-family:system-ui;">
                                                                                                {{ $value->name }}</label><br>
                                                                                        </blockquote>
                                                                                    @else
                                                                                        <blockquote class="card-bodyquote">
                                                                                            <input type="checkbox"
                                                                                                id="$value->id"
                                                                                                name="permission[]"
                                                                                                value="{{ $value->name }}">
                                                                                            <label for="permission"
                                                                                                style="color:#215467; font-size: 14px; font-family:system-ui;">
                                                                                                {{ $value->name }}</label><br>
                                                                                        </blockquote>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div> <!-- end card-body -->
                                                                        </div> <!-- end card -->
                                                                    </div> <!-- end col -->
                                                                @endforeach
                                                            </div> <!-- end row -->
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-offset-2 col-md-10">
                                                        <input class="btn btn-primary" type="submit"
                                                            style="border-radius: 25px;" value="ይስጡ">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div><!-- end col -->
                        </div>

                    @endsection
