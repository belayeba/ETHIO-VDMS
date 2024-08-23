<!DOCTYPE html>
<html lang="en">
@include('layouts.main-link')

<body>
<div class="wrapper">
    @include('layouts.header')

        <div class="leftside-menu">
            <!-- Brand Logo Light -->
            <a href="index.html" class="logo logo-light">
                <span class="logo-lg">
                    <img src="assets/images/logo.png" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="small logo">
                    </span>
                </a>

                <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!--- Sidemenu -->
                    <ul class="side-nav">

                    <li class="side-nav-title">Main</li>
                    @can('user-create')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false" aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-pages-line"></i>
                            <span> Pages </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages">
                            <ul class="side-nav-second-level">

                            <li>
                                <a href="/temp45">Starter Page</a>
                            </li>
                           
                                <li>
                                    <a href="/temp39">Contact List</a>
                                </li>
                                <li>
                                    <a href="/temp44">Profile</a>
                                </li>
                                <li>
                                    <a href="/temp46">Timeline</a>
                                </li>
                                <li>
                                    <a href="/temp41">Invoice</a>
                                </li>
                                <li>
                                    <a href="/temp40">FAQ</a>
                                </li>
                                <li>
                                    <a href="/tempe43">Pricing</a>
                                </li>
                                <li>
                                    <a href="/temp42">Maintenance</a>
                                </li>
                                <li>
                                    <a href="/temp12">Error 404</a>
                                </li>
                                <li>
                                    <a href="/temp11">Error 404-alt</a>
                                </li>
                                <li>
                                    <a href="/temp13">Error 500</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcan

                    <li class="side-nav-item">
                       <a data-bs-toggle="collapse" href="#sidebarRequest" aria-expanded="false" aria-controls="sidebarRequest" class="side-nav-link">
                            <i class=" ri-questionnaire-line"></i>
                            <span>Request Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarRequest">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('displayRequestPage')}}">Temporary vehicle request</a>
                                </li>
                                <li>
                                    <a href="{{route('vec_perm_request')}}">Permanent vehicle request</a>
                                </li>
                                <li>
                                    <a href="/director_approve_page/check">Director</a>
                                </li>
                                <li>
                                    <a href="{{route('simirit_page')}}">Dispatcher</a>
                                </li>
                                <li>
                                    <a href="/director_approve_page/perm">Pemanent Requests</a>
                                </li>
                                <li>
                                    <a href="/mentaincance_request_page">Mentencance Request</a>
                                </li>
                                <li>
                                    <a href="/fuel_request_page">Fuel Request</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarUser" aria-expanded="false" aria-controls="sidebarUser" class="side-nav-link">
                            <i class="  ri-user-fill"></i>
                            <span>User Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarUser">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('user_list')}}">Create users</a>
                                </li>
                                <!-- <li>
                                    <a href="#">Tests</a>
                                </li> -->
                                
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarOrganization" aria-expanded="false" aria-controls="sidebarOrganization" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Organization </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarOrganization">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="/cluster">Cluster</a>
                                </li>
                                <li>
                                    <a href="/department">Department</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false" aria-controls="sidebarRole" class="side-nav-link">
                            <i class="ri-shield-cross-fill"></i>
                            <span>Role Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarRole">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('roles.index') }}">Roles</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                </div>
        </div>   
        </br></br>
    @yield('content')

    @include('layouts.footer')

    @include('layouts.setting')
</div>


<!-- <script src="{{ asset('assets/js/vendor.min.js') }}"></script> -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>
</html>
