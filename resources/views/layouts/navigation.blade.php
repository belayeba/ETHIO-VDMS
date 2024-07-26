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

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false" aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-pages-line"></i>
                            <span> Pages </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages">
                            <ul class="side-nav-second-level">
                            @can('edit posts')
                            <li>
                                <a href="/temp45">Starter Page</a>
                            </li>
                            @endcan
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

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPagesAuth" aria-expanded="false" aria-controls="sidebarPagesAuth" class="side-nav-link">
                            <i class="ri-user-add-line"></i>
                            <span> Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPagesAuth">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('users')}}">User LIst</a>
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

 <!-- App js --> 
 <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
 <script src="{{ asset('assets/js/app.min.js') }}"></script>
 @stack('scripts')

</body>

<!-- Mirrored from techzaa.getappui.com/velonic/layouts/charts-apex.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:37 GMT -->
</html>
