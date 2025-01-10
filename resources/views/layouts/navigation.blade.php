<!DOCTYPE html>
<html lang="en">
@include('layouts.main-link')
<!-- ethiopian date scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.plugin.js') }}"></script>
<script src="{{ asset('assets/js/jquery.calendars.js') }}"></script>
<script src="{{ asset('assets/js/jquery.calendars.plus.js') }}"></script>
<script src="{{ asset('assets/js/jquery.calendars.picker.js') }}"></script>
<script src="{{ asset('assets/js/jquery.calendars.ethiopian.js') }}"></script>
<script src="{{ asset('assets/js/jquery.calendars.ethiopian-am.js') }}"></script>
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: 0.5em 1em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        cursor: hand;
        color: #333 !important;
        border: 1px solid transparent;
        border-radius: 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #333 !important;
        border: 1px solid #979797;
        background-color: white;
        background: -webkit-gradient(linear,
                left top,
                left bottom,
                color-stop(0%, white),
                color-stop(100%, #dcdcdc));
        background: -webkit-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: -moz-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: -ms-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: -o-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
        cursor: default;
        color: #666 !important;
        border: 1px solid transparent;
        background: transparent;
        box-shadow: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: white !important;
        border: 1px solid #111;
        background-color: #585858;
        background: -webkit-gradient(linear,
                left top,
                left bottom,
                color-stop(0%, #585858),
                color-stop(100%, #111));
        background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
        background: -moz-linear-gradient(top, #585858 0%, #111 100%);
        background: -ms-linear-gradient(top, #585858 0%, #111 100%);
        background: -o-linear-gradient(top, #585858 0%, #111 100%);
        background: linear-gradient(to bottom, #585858 0%, #111 100%);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:active {
        outline: none;
        background-color: #2b2b2b;
        background: -webkit-gradient(linear,
                left top,
                left bottom,
                color-stop(0%, #2b2b2b),
                color-stop(100%, #0c0c0c));
        background: -webkit-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -moz-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -ms-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -o-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: linear-gradient(to bottom, #2b2b2b 0%, #0c0c0c 100%);
        box-shadow: inset 0 0 3px #111;
    }
</style>

<body>
    <div class="wrapper">
        @include('layouts.header')

        <div class="leftside-menu">
            <!-- Brand Logo Light -->
            <a href="index.html" class="logo logo-light">
                <span class="logo-md">
                    <img src="{{ asset('assets/images/Aii.jpg') }}" alt="logo" style="max-width: 100%; max-height: 90%;">
                </span>
                {{-- <span class="logo-sm">
                    <img src="assets/images/Aii.jpg" alt="logo" style="max-width: 100%; max-height: 90%;">
                </span> --}}
            </a>

            <!-- Brand Logo Dark -->
            {{--  --}}

            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Main</li>
                    <li class="side-nav-item">
                        <li class="side-nav-item">
                            <a href="{{ route('home') }}" class="side-nav-link">
                                <i class="ri-dashboard-3-line"></i>
                                <span> Map </span>
                            </a>
                        </li>
                    <li class="side-nav-item">  
                        <a data-bs-toggle="collapse" href="#sidebarRequest" aria-expanded="false"
                            aria-controls="sidebarRequest" class="side-nav-link">
                            <i class=" ri-questionnaire-line"></i>
                            <span>Request Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarRequest">
                            <ul class="side-nav-second-level">
                                @can('Temporary Request Page')
                                    <li>
                                        <a href="{{ route('displayRequestPage') }}">Temporary Request</a>
                                    </li>
                                @endcan()
                                @can('Permanent Request Page')
                                    <li>
                                        <a href="{{ route('vec_perm_request') }}">Permanent Request</a>
                                    </li>
                                @endcan()
                                @can('Director Approval Page')
                                    <li>
                                        <a href="{{ route('director_temp') }}">Approve Temporary</a>
                                    </li>
                                @endcan()
                                @can('Clustor Director Apporal Page')
                                    <li>
                                        <a href="{{ route('ClusterDirector_temp') }}">Approve Temporary</a>
                                    </li>
                                @endcan()
                                @can('HR Cluster Director Approval Page')
                                    <li>
                                        <a href="{{ route('HRClusterDirector_temp') }}">Approve Temporary</a>
                                    </li>
                                @endcan()
                                @can('Transport Director')
                                    <li>
                                        <a href="{{ route('TransportDirector_temp') }}">Approve Temporary</a>
                                    </li>
                                @endcan()
                                @can('Dispatcher Page')
                                    <li>
                                        <a href="{{ route('simirit_page') }}">Temporarly Assign</a>
                                    </li>
                                @endcan()
                                @can('Vehicle Director Page')
                                    <li>
                                        <a href="{{ route('perm_vec_director_page') }}">Approve Pemanent</a>
                                    </li>
                                @endcan()
                                @can('Dispatcher')
                                    <li>
                                        <a href="{{ route('perm_vec_simirit_page') }}">Assign Permanent</a>
                                    </li>
                                @endcan()
                                @can('Request Return')
                                    <li>
                                        <a href="{{ route('return_permanent_request_page') }}">Return Permanent</a>
                                    </li>
                                @endcan()
                                @can('Approve Return')
                                    <li>
                                        <a href="{{ route('director_approval_page') }}">Approve Return</a>
                                    </li>
                                @endcan()
                                @can('Take Back to Transport')
                                    <li>
                                        <a href="{{ route('vehicle_director_page') }}">Return Permanent</a>
                                    </li>
                                @endcan()
                                @can('Request Mentenance')
                                    <li>
                                        <a href="/mentaincance_request_page">Maintenance </a>
                                    </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarFuel" aria-expanded="false"
                            aria-controls="sidebarFuel" class="side-nav-link">
                            <i class="  ri-gas-station-fill"></i>
                            <span>Fuel Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarFuel">
                            <ul class="side-nav-second-level">
                                @can('Set Feul Cost')
                                    <li>
                                        <a href="{{ route('all_fuel_cost') }}">Set Feul Cost</a>
                                    </li>
                                @endcan()
                                @can('Request Fuel')
                                    <li>
                                        <a href="{{ route('permanenet_fuel_request') }}">Request</a>
                                    </li>
                                @endcan()
                                @can('Finance Accept')
                                    <li>
                                        <a href="{{ route('finance_approve_fuel_page') }}">Approve</a>
                                    </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @can('Create User')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="false"
                                aria-controls="sidebarUser" class="side-nav-link">
                                <i class="  ri-user-fill"></i>
                                <span>User Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarUser">
                                <ul class="side-nav-second-level">
                                    @can('Create User')
                                        <li>
                                            <a href="{{ route('user_list') }}">Create users</a>
                                        </li>
                                    @endcan()
                                    @can('Create Driver')
                                        <li>
                                            <a href="{{ route('driver.index') }}">Driver Registration</a>
                                        </li>
                                    @endcan()
                                    @can('Change Driver')
                                        <li>
                                            <a href="{{ route('driver.switch') }}">Driver Change</a>
                                        </li>
                                    @endcan()
                                    {{-- @can('Accept Driver Change') --}}
                                        <li>
                                            <a href="{{ route('driverchange.request') }}">Driver Accept</a>
                                        </li>
                                    {{-- @endcan() --}}
                                </ul>
                            </div>
                        </li>
                    @endcan()
                    @can('Vehicle Registration')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarVehicle" aria-expanded="false"
                                aria-controls="sidebarVehicle" class="side-nav-link">
                                <i class=" ri-taxi-fill"></i>
                                <span>Vehicle Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarVehicle">
                                <ul class="side-nav-second-level">
                                    @can('Vehicle Registration')
                                        <li>
                                            <a href="{{ route('vehicleRegistration.index') }}">Registration </a>
                                        </li>
                                    @endcan()
                                    @can('Fill Attendance')
                                        <li>
                                            <a href="{{ route('attendance.index') }}">Vehicle Attendance</a>
                                        </li>
                                    @endcan()
                                    @can('Vehicle Part Registration')
                                        <li>
                                            <a href="{{ route('vehicle_parts.index') }}">Vehicle Parts</a>
                                        </li>
                                    @endcan()
                                    @can('Vehicle Part Registration')
                                        <li>
                                            <a href="{{ route('quota.index') }}">Change Fuel Quata</a>
                                        </li>
                                    @endcan()
                                    @can('Vehicle Inspection')
                                        <li>
                                            <a href="{{ route('inspection.page') }}">Inspection</a>
                                        </li>
                                    @endcan()
                                    @can('Daily KM Registration')
                                        <li>
                                            <a href="{{ route('daily_km.page') }}">Daily KM</a>
                                        </li>
                                    @endcan()
                                </ul>
                            </div>
                        </li>
                    @endcan()
                    @can('Create Cluster')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarOrganization" aria-expanded="false"
                                aria-controls="sidebarOrganization" class="side-nav-link">
                                <i class="ri-share-line"></i>
                                <span> Organization </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarOrganization">
                                <ul class="side-nav-second-level">
                                    @can('Create Cluster')
                                        <li>
                                            <a href="{{ route('cluster.index') }}">Cluster</a>
                                        </li>
                                    @endcan()
                                    @can('Create Department')
                                        <li>
                                            <a href="/department">Department</a>
                                        </li>
                                    @endcan()
                                </ul>
                            </div>
                        </li>
                    @endcan()
                    @can('Create Role')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false"
                                aria-controls="sidebarRole" class="side-nav-link">
                                <i class="ri-shield-cross-fill"></i>
                                <span>Role Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarRole">
                                <ul class="side-nav-second-level">
                                    @can('Create Role')
                                        <li>
                                            <a href="{{ route('roles.index') }}">Roles</a>
                                        </li>
                                    @endcan()
                                </ul>
                            </div>
                        </li>
                    @endcan()
                    @can('Daily KM Report')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarReport" aria-expanded="false"
                                aria-controls="sidebarReport" class="side-nav-link">
                                <i class=" ri-file-fill"></i>
                                <span>Report</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarReport">
                                <ul class="side-nav-second-level">
                                    @can('Daily KM Report')
                                        <li>
                                            <a href="{{ route('dailyreport.index') }}">Daily KM</a>
                                        </li>
                                    @endcan()
                                    @can('View Attendance Report')
                                        <li>
                                            <a href="{{ route('attendancereport.index') }}">Attendance Report</a>
                                        </li>
                                    @endcan()
                                    @can('Permananet Vehicle Request')
                                        <li>
                                            <a href="{{ route('dailyreport.permanentReport') }}">Permanent</a>
                                        </li>
                                    @endcan()
                                    @can('Temporary Vehicle Request')
                                        <li>
                                            <a href="{{ route('dailyreport.temporaryReport') }}">Temporary</a>
                                        </li>
                                    @endcan()
                                    {{-- @can('Temporary Vehicle Request') --}}
                                    <li>
                                        <a href="{{ route('dailyreport.vehicleReport') }}">Vehicle</a>
                                    </li>
                                    {{-- @endcan() --}}
                                </ul>
                            </div>
                        </li>
                    @endcan()
                    @can('Route Registration')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#routeManagement" aria-expanded="false"
                                aria-controls="routeManagement" class="side-nav-link">
                                <i class=" ri-route-fill"></i>
                                <span>Route Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="routeManagement">
                                <ul class="side-nav-second-level">
                                    @can('Employee Change Route')
                                       <li>
                                            <a href="{{ route('route.self_route_self') }}">My Route</a>
                                        </li>
                                        @endcan()
                                    @can('Change Route For Employee')
                                        <li>
                                            <a href="{{ route('change.location_change_approve') }}">Approve Location Change</a>
                                        </li>
                                        @endcan()
                                    @can('Route Registration')
                                        <li>
                                            <a href="{{ route('route.index') }}">Registration</a>
                                        </li>
                                    @endcan()
                                    @can('Assign Employee to Route')
                                        <li>
                                            <a href="{{ route('route.show') }}">Employee Service</a>
                                        </li>
                                    @endcan()
                                </ul>
                            </div>
                        </li>
                    @endcan()
                    @can('Letter Related')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#letterManagement" aria-expanded="false"
                            aria-controls="letterManagement" class="side-nav-link">
                            <i class=" ri-file-paper-fill"></i>
                            <span>Letter Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="letterManagement">
                            <ul class="side-nav-second-level">
                                @can('Attach Letter')
                                    <li>
                                        <a href="{{ route('letter.index') }}">Letter Request</a>
                                    </li>
                                @endcan()
                                @can('Letter Review')
                                    <li>
                                        <a href="{{ route('letter.review.page') }}">Letter Review</a>
                                    </li>
                                @endcan()
                                @can('Letter Approve')
                                    <li>
                                        <a href="{{ route('letter.approve.page') }}">Letter Approve</a>
                                    </li>
                                @endcan()
                                @can('Purchase Letter')
                                    <li>
                                        <a href="{{ route('purchase.accept.page') }}">Purchase Accept</a>
                                    </li>
                                @endcan()
                                @can('Finance Letter')
                                    <li>
                                        <a href="{{ route('finance.accept.page') }}">Finanace Accept</a>
                                    </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endcan()
            </div>
        </div>
        </br></br>
        @yield('content')

        @include('layouts.footer')

        {{-- @include('layouts.setting') --}}
    </div>

    <!-- <script src="{{ asset('assets/js/app.min.js') }}"></script> -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

</body>

</html>
{{-- <script src="{{ asset('assets/js/vendor.min.js') }}"></script>  --}}
