<!DOCTYPE html>
<html lang="en">
@include('layouts.main-link')
@include('layouts.header')

@include('layouts.setting')


<body>
    <!-- Begin page -->
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
            <a href="/temp29" class="side-nav-link">
                <i class="ri-dashboard-3-line"></i>
                <span class="badge bg-success float-end">9+</span>
                <span> Dashboard </span>
            </a>
        </li>


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
    </div>
    </div>
    <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <script>document.write(new Date().getFullYear())</script> © Velonic - Theme by <b>Techzaa</b>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>