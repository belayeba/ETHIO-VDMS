@extends('layouts.navigation')

@section('content')
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Daily km Report</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Daily km Report</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="box_header common_table_header">
                                            <div class="main-title d-md-flex">
                                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">Filter Report</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <form action="{{ route('vehicle.filterReport') }}" method="GET">

                                        <div class="">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    </br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form action="{{ route('vehicle.filterReport') }}" method="GET">
                                                <!-- Plate Number Filter -->
                                                <div class="col-lg-4">
                                                    <label for="selectPlateNumber" class="form-label">Plate Number</label>
                                                    <select id="selectPlateNumber" name="plate_number" class="form-select">
                                                        <option value="">Select Plate Number</option>
                                                        @foreach($vehicles as $vehicle)
                                                            <option value="{{ $vehicle->plate_number }}">{{ $vehicle->plate_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <!-- Driver Name Filter -->
                                                <div class="col-lg-4">
                                                    <label for="selectName" class="form-label">Name</label>
                                                    <select id="selectName" name="driver_name" class="form-select">
                                                        <option value="">Select Driver</option>
                                                        @foreach($drivers as $driver)
                                                            <option value="{{ $driver->driver_id }}">{{ $driver->users->username }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <!-- Date Range Picker -->
                                                <div class="col-lg-4 z-3">
                                                    <label for="daterangetime" class="form-label">Date Range Pick With Times</label>
                                                    <input type="text" class="form-control date" id="datepicker" name="date_range" data-toggle="date-picker" data-time-picker="true" data-locale='{"format": "DD/MM hh:mm A"}'>
                                                </div>

                                                {{-- <input id="datepicker"/> --}}
                                                <script>
                                                const picker = new easepick.create({
                                                    element: document.getElementById('datepicker'),
                                                    css: [
                                                    'https://cdn.jsdelivr.net/npm/@easepick/core@1.2.1/dist/index.css',
                                                    'https://cdn.jsdelivr.net/npm/@easepick/range-plugin@1.2.1/dist/index.css',
                                                    ],
                                                    plugins: ['RangePlugin'],
                                                    RangePlugin: {
                                                    tooltip: true,
                                                    },
                                                });
                                                </script>

                                                {{-- <div class="col-md-3">
                                                <div class="position-relative">
                                                    <label for="driving-license" class="form-label">Date</label>
                                                    <input id="fill_date" name="Driving_license" class="form-control" placeholder="When" type="text">
                                                </div>
                                            </div>
                                             <script> 
                                                $('#fill_date').calendarsPicker({ 
                                                    calendar: $.calendars.instance('ethiopian', 'am'), 
                                                    pickerClass: 'myPicker', 
                                                    dateFormat: 'yyyy-mm-dd' 
                                                });
                                             </script> --}}
                                            </div>
                                            
                                            <!-- Filter Button -->
                                            <div class="row mt-3">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn btn-info">Filter <i class="ri-arrow-right-line ms-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </from>
                                    
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title">Daily km Report</h4>
                                <p class="text-muted mb-0">
                                    The Buttons extension for DataTables provides a common set of options, API
                                    methods and styling to display buttons on a page
                                    that will interact with a DataTable.
                                </p>
                            </div>
                            <div class="card-body">
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Plate Number</th>
                                            <th>Morning KM</th>
                                            <th>Night KM</th>
                                            <th>Daily KM Difference </th>
                                            <th>Night KM Difference </th>

                                        </tr>
                                    </thead>


                                    <tbody>
                                        @foreach($dailkms as $km)
                                            <tr>
                                                <td>{{ $km->date }}</td>
                                                <td>{{ $km->vehicle->plate_number ?? 'N/A' }}</td>
                                                <td>{{ $km->morning_km }}</td>
                                                <td>{{ $km->afternoon_km }}</td>
                                                <td>{{ $km->daily_km  }}</td>
                                                <td>{{ $km->night_km ?? 'NULL'  }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div> <!-- end row-->


            </div> <!-- content -->

        </div>

    </div>
   
  
@endsection


