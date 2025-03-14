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
            {{-- --}}

            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Main</li>
                    <li class="side-nav-item">
                    <li class="side-nav-item">
                        <a href="{{ route('home') }}" class="side-nav-link">
                            <i class="ri-dashboard-3-line"></i>
                            <span>@lang('messages.Map')</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarRequest" aria-expanded="false"
                            aria-controls="sidebarRequest" class="side-nav-link">
                            <i class=" ri-questionnaire-line"></i>
                            <span>@lang('messages.Request Management')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarRequest">
                            <ul class="side-nav-second-level">
                                @can('Temporary Request Page')
                                <li>
                                    <a href="{{ route('displayRequestPage') }}">@lang('messages.Temporary Request')</a>
                                </li>
                                @endcan()
                                @can('Permanent Request Page')
                                <li>
                                    <a href="{{ route('vec_perm_request') }}">@lang('messages.Request Permanent Vehicle')</a>
                                </li>
                                @endcan()
                                @can('Director Approval Page')
                                <li>
                                    <a href="{{ route('director_temp') }}">@lang('messages.Approval Temporary')</a>
                                </li>
                                @endcan()
                                @can('Clustor Director Apporal Page')
                                <li>
                                    <a href="{{ route('ClusterDirector_temp') }}">@lang('messages.Approval Temporary')</a>
                                </li>
                                @endcan()
                                @can('HR Cluster Director Approval Page')
                                <li>
                                    <a href="{{ route('HRClusterDirector_temp') }}">@lang('messages.Approval Temporary')</a>
                                </li>
                                @endcan()
                                @can('Transport Director')
                                <li>
                                    <a href="{{ route('TransportDirector_temp') }}">@lang('messages.Approval Temporary')</a>
                                </li>
                                @endcan()
                                @can('Dispatcher Page')
                                <li>
                                    <a href="{{ route('simirit_page') }}">@lang('messages.Temporary Assign')</a>
                                </li>
                                @endcan()
                                @can('Vehicle Director Page')
                                <li>
                                    <a href="{{ route('perm_vec_director_page') }}">@lang('messages.Approve Permanent')</a>
                                </li>
                                @endcan()
                                @can('Dispatcher')
                                <li>
                                    <a href="{{ route('perm_vec_simirit_page') }}">@lang('messages.Assign Permanent')</a>
                                </li>
                                @endcan()
                                @can('Request Return')
                                <li>
                                    <a href="{{ route('return_permanent_request_page') }}">@lang('messages.Return Permanent')</a>
                                </li>
                                @endcan()
                                @can('Approve Return')
                                <li>
                                    <a href="{{ route('director_approval_page') }}">@lang('messages.Approve Return')</a>
                                </li>
                                @endcan()
                                @can('Take Back to Transport')
                                <li>
                                    <a href="{{ route('vehicle_director_page') }}">@lang('messages.Return Permanent')</a>
                                </li>
                                @endcan()

                            </ul>
                        </div>
                    </li>


                    @if(auth()->user()->can('Set Feul Cost') || auth()->user()->can('Request Fuel') ||
                    auth()->user()->can('Finance Accept'))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarFuel" aria-expanded="false"
                            aria-controls="sidebarFuel" class="side-nav-link">
                            <i class="  ri-gas-station-fill"></i>
                            <span>@lang('messages.Fuel Management')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarFuel">
                            <ul class="side-nav-second-level">
                                @can('Set Fuel Cost')
                                <li>
                                    <a href="{{ route('all_fuel_cost') }}">@lang('messages.Set Feul Cost')</a>
                                </li>
                                @endcan()
                                @can('Request Fuel')
                                <li>
                                    <a href="{{ route('permanenet_fuel_request') }}">@lang('messages.Fuel Request')</a>
                                </li>
                                @endcan()
                                @can('Finance Accept')
                                <li>
                                    <a href="{{ route('finance_approve_fuel_page') }}">@lang('messages.Approve')</a>
                                </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(auth()->user()->can('Request Maintenance') || auth()->user()->can('Approve Maintenance') ||
                    auth()->user()->can('Inspect Maintenance') || auth()->user()->can('Maintenance for Dispatcher')||
                    auth()->user()->can('Final Maintenance'))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarMaintenance" aria-expanded="false"
                            aria-controls="sidebarMaintenance" class="side-nav-link">
                            <i class="ri-settings-5-fill "></i>
                            <span>@lang('messages.Maintenance')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarMaintenance">
                            <ul class="side-nav-second-level">
                                @can('Request Maintenance')
                                <li>
                                    <a href="{{route('maintenance_request')}}">@lang('messages.Request Maintenance') </a>
                                </li>
                                @endcan()
                                @can('Approve Maintenance')
                                <li>
                                    <a href="{{route('maintenance_approver')}}">Maintenance Approver</a>
                                </li>
                                @endcan()
                                @can('Inspect Maintenance')
                                <li>
                                    <a href="{{route('maintenance_inspection')}}">Maintenance Inspection</a>
                                </li>
                                @endcan()
                                @can('Maintenance for Dispatcher')
                                <li>
                                    <a href="{{route('simirit_display')}}">Simirit Approve</a>
                                </li>
                                @endcan()
                                @can('Final Maintenance')
                                <li>
                                    <a href="{{route('Final_display')}}">Finalize Maintenance</a>
                                </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(auth()->user()->can('Create User') || auth()->user()->can('Create Driver') ||
                    auth()->user()->can('Change Driver') || auth()->user()->can('Accept Driver Change'))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="false"
                            aria-controls="sidebarUser" class="side-nav-link">
                            <i class="  ri-user-fill"></i>
                            <span>@lang('messages.User Management')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarUser">
                            <ul class="side-nav-second-level">
                                @can('Create User')
                                <li>
                                    <a href="{{ route('user_list') }}">@lang('messages.Create Users')</a>
                                </li>
                                @endcan()
                                @can('Create Driver')
                                <li>
                                    <a href="{{ route('driver.index') }}">@lang('messages.Driver Registration')</a>
                                </li>
                                @endcan()
                                @can('Change Driver')
                                <li>
                                    <a href="{{ route('driver.switch') }}">@lang('messages.Driver Change')</a>
                                </li>
                                @endcan()
                                @can('Accept Driver Change')
                                <li>
                                    <a href="{{ route('driverchange.request') }}">@lang('messages.Driver Accept')</a>
                                </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endif()

                    @if(auth()->user()->can('Vehicle Registration') || auth()->user()->can('Fill Attendance') ||
                    auth()->user()->can('Vehicle Part Registration') || auth()->user()->can('Vehicle Inspection') || auth()->user()->can('Daily KM Registration'))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarVehicle" aria-expanded="false"
                            aria-controls="sidebarVehicle" class="side-nav-link">
                            <i class=" ri-taxi-fill"></i>
                            <span>@lang('messages.Vehicle Management')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarVehicle">
                            <ul class="side-nav-second-level">
                                @can('Vehicle Registration')
                                <li>
                                    <a href="{{ route('vehicleRegistration.index') }}">@lang('messages.Vehicle Registration') </a>
                                </li>
                                @endcan()
                                @can('Fill Attendance')
                                <li>
                                    <a href="{{ route('attendance.index') }}">Vehicle Attendance</a>
                                </li>
                                @endcan()
                                @can('Vehicle Part Registration')
                                <li>
                                    <a href="{{ route('vehicle_parts.index') }}">@lang('messages.Vehicle Parts')</a>
                                </li>
                                @endcan()
                                @can('Vehicle Part Registration')
                                <li>
                                    <a href="{{ route('quota.index') }}">@lang('messages.Change Fuel Quota')</a>
                                </li>
                                @endcan()
                                @can('Vehicle Inspection')
                                <li>
                                    <a href="{{ route('inspection.page') }}">@lang('messages.Vehicle Inspection')</a>
                                </li>
                                @endcan()
                                @can('Daily KM Registration')
                                <li>
                                    <a href="{{ route('daily_km.page') }}">@lang('messages.Daily KM')</a>
                                </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endif()

                    @if(auth()->user()->can('Create Cluster') || auth()->user()->can('Create Department'))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarOrganization" aria-expanded="false"
                            aria-controls="sidebarOrganization" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> @lang('messages.Organization') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarOrganization">
                            <ul class="side-nav-second-level">
                                @can('Create Cluster')
                                <li>
                                    <a href="{{ route('cluster.index') }}">@lang('messages.Cluster')</a>
                                </li>
                                @endcan()
                                @can('Create Department')
                                <li>
                                    <a href="/department">@lang('messages.Department')</a>
                                </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endif()

                    @can('Create Role')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false"
                            aria-controls="sidebarRole" class="side-nav-link">
                            <i class="ri-shield-cross-fill"></i>
                            <span>@lang('messages.Role Management')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarRole">
                            <ul class="side-nav-second-level">
                                @can('Create Role')
                                <li>
                                    <a href="{{ route('roles.index') }}">@lang('messages.Role')</a>
                                </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endcan()

                    @if(auth()->user()->can('Daily KM Report') || auth()->user()->can('View Attendance Report')
                    || auth()->user()->can('Permananet Vehicle Request') || auth()->user()->can('Temporary Vehicle Request'))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarReport" aria-expanded="false"
                            aria-controls="sidebarReport" class="side-nav-link">
                            <i class=" ri-file-fill"></i>
                            <span>@lang('messages.Report')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarReport">
                            <ul class="side-nav-second-level">
                                @can('Daily KM Report')
                                <li>
                                    <a href="{{ route('dailyreport.index') }}">@lang('messages.Daily KM')</a>
                                </li>
                                @endcan()
                                @can('View Attendance Report')
                                <li>
                                    <a href="{{ route('attendancereport.index') }}">Attendance Report</a>
                                </li>
                                @endcan()
                                @can('Permananet Vehicle Request')
                                <li>
                                    <a href="{{ route('dailyreport.permanentReport') }}">@lang('messages.Permanent')</a>
                                </li>
                                @endcan()
                                @can('Temporary Vehicle Request')
                                <li>
                                    <a href="{{ route('dailyreport.temporaryReport') }}">@lang('messages.Temporary')</a>
                                </li>
                                @endcan()
                                @can('Maintance Request')
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endif()

                    @if(auth()->user()->can('Employee Change Route') || auth()->user()->can('Change Route For Employee')
                    || auth()->user()->can('Route Registration') || auth()->user()->can('Assign Employee to Route'))
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#routeManagement" aria-expanded="false"
                            aria-controls="routeManagement" class="side-nav-link">
                            <i class=" ri-route-fill"></i>
                            <span>@lang('messages.Route Management')</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="routeManagement">
                            <ul class="side-nav-second-level">
                                @can('Employee Change Route')
                                <li>
                                    <a href="{{ route('route.self_route_self') }}">@lang('messages.My Route')</a>
                                </li>
                                @endcan()
                                @can('Change Route For Employee')
                                <li>
                                    <a href="{{ route('change.location_change_approve') }}">@lang('messages.Approve Location Change')</a>
                                </li>
                                @endcan()
                                @can('Route Registration')
                                <li>
                                    <a href="{{ route('route.index') }}">@lang('messages.Route Registration')</a>
                                </li>
                                @endcan()
                                @can('Assign Employee to Route')
                                <li>
                                    <a href="{{ route('route.show') }}">@lang('messages.Employee Service')</a>
                                </li>
                                @endcan()
                            </ul>
                        </div>
                    </li>
                    @endif()

                    @if(auth()->user()->can('Attach Letter') || auth()->user()->can('Letter Review')
                    || auth()->user()->can('Letter Approve') || auth()->user()->can('Purchase Letter')
                    || auth()->user()->can('Finance Letter'))
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
                                    <a href="{{ route('letter.index') }}">Prepare Letter</a>
                                </li>
                                @endcan()
                                @can('Letter Review')
                                <li>
                                    <a href="{{ route('letter.review.page') }}">Review Letter</a>
                                </li>
                                @endcan()
                                @can('Letter Approve')
                                <li>
                                    <a href="{{ route('letter.approve.page') }}">Approve Letter</a>
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
                    @endif()
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
{{-- <script src="{{ asset('assets/js/vendor.min.js') }}"></script> --}}