@extends('layouts.navigation')

@section('content')
    <div class="content-page">
        <div class="content">

                @if (Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5"
                        role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong>Error - </strong> {!! session('error_message') !!}
                    </div>
                @endif

                @if (Session::has('success_message'))
                    <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5"
                        role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong> Success- </strong> {!! session('success_message') !!}
                    </div>
                @endif
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">

                                    <form action="{{ route('dailyreport.filterPermanentReport') }}" method="GET">

                                        <div class="">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    </br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="filter" value="permanent_filter">
                                                <!-- Plate Number Filter -->
                                                <div class="col-lg-2">
                                                    <label for="selectPlateNumber" class="form-label">@lang('messages.Plate Number')</label>
                                                    <select id="selectPlateNumber" name="plate_number"
                                                        class="form-select">
                                                        <option value="">Select Plate Number</option>
                                                        @foreach ($vehicles as $vehicle)
                                                            <option value="{{ $vehicle->plate_number }}">
                                                                {{ $vehicle->plate_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label for="selectName" class="form-label">@lang('messages.Name')</label>
                                                    <select id="selectName" name="driver_name" class="form-select">
                                                        <option value="">Select Driver</option>
                                                        @foreach ($drivers as $driver)
                                                            <option value="{{ $driver->username }}">
                                                                {{ $driver->first_name .' '.$driver->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label for="selectDepartment"
                                                        class="form-label">@lang('messages.Department')</label>
                                                    <select id="selectDepartment" name="department"
                                                        class="form-select">
                                                        <option value="">Department</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->department_id }}">
                                                                {{ $department->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label for="selectCluster" class="form-label">@lang('messages.Cluster')</label>
                                                    <select id="selectCluster" name="cluster" class="form-select">
                                                        <option value="">Cluster</option>
                                                        @foreach ($clusters as $cluster)
                                                            <option value="{{ $cluster->cluster_id }}">
                                                                {{ $cluster->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Date Range Picker -->
                                                <div class="col-lg-1">
                                                    <label for="daterangetime" class="form-label">Date: &nbsp; From</label>
                                                    <input type="text" class="form-control date" id="startdate"
                                                        name="start_date">
                                                        <script>
                                                            $('#startdate').calendarsPicker({
                                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                                pickerClass: 'myPicker',
                                                                dateFormat: 'yyyy-mm-dd'
                                                            });
                                                        </script>
                                                </div>

                                                <div class="col-lg-1">
                                                    <label for="daterangetime" class="form-label">To</label>
                                                    <input type="text" class="form-control date" id="end_date"
                                                        name="end_date">  
                                                        <script>
                                                            $('#end_date').calendarsPicker({
                                                                calendar: $.calendars.instance('ethiopian', 'am'),
                                                                pickerClass: 'myPicker',
                                                                dateFormat: 'yyyy-mm-dd'
                                                            });
                                                        </script>  
                                                </div>

                                                <div class="col-lg-2 mt-3">
                                                    <button type="submit" class="btn btn-info">@lang('messages.Filter') <i
                                                            class="ri-arrow-right-line ms-1"></i></button>
                                                    
                                                    <button type="submit" class="btn btn-success" onclick="document.getElementById('export').value=1">@lang('messages.Export')</button>
                                                    <input type="hidden" id="export" name="export" value="0">
                                                </div>

                                                
                                            </div>
                                            <div class="col-lg-4 mt-3">
                                                <!-- Set export to 1 when exporting -->
                                               
                                            </div>
                                        </div>
                                    </form>

                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('messages.Date Given') }}</th>
                                                    <th>{{ __('messages.Requested By') }}</th>
                                                    <th>{{ __('messages.Plate Number') }}</th>
                                                    <th>{{ __('messages.Reason') }}</th>
                                                    <th>{{ __('messages.Mileage') }}</th>
                                                    <th>{{ __('messages.Department') }}</th>
                                                    <th>{{ __('messages.Cluster') }}</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($dailkms as $km)
                                                    <tr>
                                                        <td>{{ $km->given_date }}</td>
                                                        <td>{{ $km->requested_by }}</td>
                                                        <td>{{ $km->plate_number }}</td>
                                                        <td>{{ $km->purpose }}</td>
                                                        <td>{{ $km->mileage }}</td>
                                                        <td>{{ $km->department_name }}</td>
                                                        <td>{{ $km->cluster_name }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->
                </div> <!-- content -->
             </div>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
        @endsection
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
