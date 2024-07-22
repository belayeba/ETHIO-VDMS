<!DOCTYPE html>
<html lang="en" data-layout="topnav" data-topbar-color="dark" data-menu-color="light">
@include('layouts.main-link')
@include('layouts.header')
@include('layouts.setting')




<body>
    <!-- Begin page -->
    <div class="wrapper">

       
        
        <!-- ========== Horizontal Menu Start ========== -->
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="index.html" id="topnav-dashboards" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-dashboard-3-line"></i>Dashboards
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-pages-line"></i>Pages <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Authenitication <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                            <a href="auth-login.html" class="dropdown-item">Login</a>
                                            <a href="auth-register.html" class="dropdown-item">Register</a>
                                            <a href="auth-logout.html" class="dropdown-item">Logout</a>
                                            <a href="auth-forgotpw.html" class="dropdown-item">Forgot Password</a>
                                            <a href="auth-lock-screen.html" class="dropdown-item">Lock Screen</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-error"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Error <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-error">
                                            <a href="error-404.html" class="dropdown-item">Error 404</a>
                                            <a href="error-404-alt.html" class="dropdown-item">Error 404-alt</a>
                                            <a href="error-500.html" class="dropdown-item">Error 500</a>
                                        </div>
                                    </div>
                                    <a href="pages-starter.html" class="dropdown-item">Starter Page</a>
                                    <a href="pages-contact-list.html" class="dropdown-item">Contact List</a>
                                    <a href="pages-profile.html" class="dropdown-item">Profile</a>
                                    <a href="pages-timeline.html" class="dropdown-item">Timeline</a>
                                    <a href="pages-invoice.html" class="dropdown-item">Invoice</a>
                                    <a href="pages-faq.html" class="dropdown-item">FAQ</a>
                                    <a href="pages-pricing.html" class="dropdown-item">Pricing</a>
                                    <a href="pages-maintenance.html" class="dropdown-item">Maintenance</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-briefcase-line"></i>Components <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ui-kit"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Base UI 1 <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-ui-kit">
                                            <a href="ui-accordions.html" class="dropdown-item">Accordions</a>
                                            <a href="ui-alerts.html" class="dropdown-item">Alerts</a>
                                            <a href="ui-avatars.html" class="dropdown-item">Avatars</a>
                                            <a href="ui-badges.html" class="dropdown-item">Badges</a>
                                            <a href="ui-breadcrumb.html" class="dropdown-item">Breadcrumb</a>
                                            <a href="ui-buttons.html" class="dropdown-item">Buttons</a>
                                            <a href="ui-cards.html" class="dropdown-item">Cards</a>
                                            <a href="ui-carousel.html" class="dropdown-item">Carousel</a>
                                            <a href="ui-dropdowns.html" class="dropdown-item">Dropdowns</a>
                                            <a href="ui-embed-video.html" class="dropdown-item">Embed Video</a>
                                            <a href="ui-grid.html" class="dropdown-item">Grid</a>
                                            <a href="ui-list-group.html" class="dropdown-item">List Group</a>
                                            <a href="ui-links.html" class="dropdown-item">Links</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ui-kit2"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Base UI 2 <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-ui-kit2">
                                            <a href="ui-modals.html" class="dropdown-item">Modals</a>
                                            <a href="ui-notifications.html" class="dropdown-item">Notifications</a>
                                            <a href="ui-offcanvas.html" class="dropdown-item">Offcanvas</a>
                                            <a href="ui-placeholders.html" class="dropdown-item">Placeholders</a>
                                            <a href="ui-pagination.html" class="dropdown-item">Pagination</a>
                                            <a href="ui-popovers.html" class="dropdown-item">Popovers</a>
                                            <a href="ui-progress.html" class="dropdown-item">Progress</a>
                                            <a href="ui-spinners.html" class="dropdown-item">Spinners</a>
                                            <a href="ui-tabs.html" class="dropdown-item">Tabs</a>
                                            <a href="ui-tooltips.html" class="dropdown-item">Tooltips</a>
                                            <a href="ui-typography.html" class="dropdown-item">Typography</a>
                                            <a href="ui-utilities.html" class="dropdown-item">Utilities</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-extended-ui"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Extended UI <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-extended-ui">
                                            <a href="extended-portlets.html" class="dropdown-item">Portlets</a>
                                            <a href="extended-scrollbar.html" class="dropdown-item">Scrollbar</a>
                                            <a href="extended-range-slider.html" class="dropdown-item">Range Slider</a>
                                            <a href="extended-scrollspy.html" class="dropdown-item">Scrollspy</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-forms"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Forms <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-forms">
                                            <a href="form-elements.html" class="dropdown-item">Basic Elements</a>
                                            <a href="form-advanced.html" class="dropdown-item">Form Advanced</a>
                                            <a href="form-validation.html" class="dropdown-item">Form Validation</a>
                                            <a href="form-wizard.html" class="dropdown-item">Form Wizard</a>
                                            <a href="form-fileuploads.html" class="dropdown-item">File Uploads</a>
                                            <a href="form-editors.html" class="dropdown-item">Form Editors</a>
                                            <a href="form-image-crop.html" class="dropdown-item">Image Crop</a>
                                            <a href="form-x-editable.html" class="dropdown-item">X Editable</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Charts <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                            <a href="charts-apex.html" class="dropdown-item">Apex Charts</a>
                                            <a href="charts-chartjs.html" class="dropdown-item">Chartjs</a>
                                            <a href="charts-sparklines.html" class="dropdown-item">Sparkline Charts</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-tables"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Tables <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-tables">
                                            <a href="tables-basic.html" class="dropdown-item">Basic Tables</a>
                                            <a href="tables-datatable.html" class="dropdown-item">Data Tables</a>
                                            <a href="tables-editable.html" class="dropdown-item">Editable Tables</a>
                                            <a href="tables-responsive.html" class="dropdown-item">Responsive Table</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Icons <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                            <a href="icons-remixicons.html" class="dropdown-item">Remix Icons</a>
                                            <a href="icons-bootstrap.html" class="dropdown-item">Bootstrap Icons</a>
                                            <a href="icons-mdi.html" class="dropdown-item">Material Design Icons</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-maps"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Maps <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-maps">
                                            <a href="maps-google.html" class="dropdown-item">Google Maps</a>
                                            <a href="maps-vector.html" class="dropdown-item">Vector Maps</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-layout-line"></i>Layouts <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                    <a href="layouts-horizontal.html" class="dropdown-item" target="_blank">Horizontal</a>
                                    <a href="layouts-light-sidebar.html" class="dropdown-item" target="_blank">Light Sidebar</a>
                                    <a href="layouts-sm-sidebar.html" class="dropdown-item" target="_blank">Small Sidebar</a>
                                    <a href="layouts-collapsed-sidebar.html" class="dropdown-item" target="_blank">Collapsed Sidebar</a>
                                    <a href="layouts-unsticky-layout.html" class="dropdown-item" target="_blank">Unsticky Layout</a>
                                    <a href="layouts-boxed.html" class="dropdown-item" target="_blank">Boxed Layout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ========== Horizontal Menu End ========== -->
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Layout</a></li>
                                        <li class="breadcrumb-item active">Horizontal</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Horizontal</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="card widget-flat text-bg-pink">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="ri-eye-line widget-icon"></i>
                                    </div>
                                    <h6 class="text-uppercase mt-0" title="Customers">Daily Visits</h6>
                                    <h2 class="my-2">8,652</h2>
                                    <p class="mb-0">
                                        <span class="badge bg-white bg-opacity-10 me-1">2.97%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xxl-3 col-sm-6">
                            <div class="card widget-flat text-bg-purple">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="ri-wallet-2-line widget-icon"></i>
                                    </div>
                                    <h6 class="text-uppercase mt-0" title="Customers">Revenue</h6>
                                    <h2 class="my-2">$9,254.62</h2>
                                    <p class="mb-0">
                                        <span class="badge bg-white bg-opacity-10 me-1">18.25%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xxl-3 col-sm-6">
                            <div class="card widget-flat text-bg-info">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="ri-shopping-basket-line widget-icon"></i>
                                    </div>
                                    <h6 class="text-uppercase mt-0" title="Customers">Orders</h6>
                                    <h2 class="my-2">753</h2>
                                    <p class="mb-0">
                                        <span class="badge bg-white bg-opacity-25 me-1">-5.75%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xxl-3 col-sm-6">
                            <div class="card widget-flat text-bg-primary">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="ri-group-2-line widget-icon"></i>
                                    </div>
                                    <h6 class="text-uppercase mt-0" title="Customers">Users</h6>
                                    <h2 class="my-2">63,154</h2>
                                    <p class="mb-0">
                                        <span class="badge bg-white bg-opacity-10 me-1">8.21%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                                        <a data-bs-toggle="collapse" href="#weeklysales-collapse" role="button" aria-expanded="false" aria-controls="weeklysales-collapse"><i class="ri-subtract-line"></i></a>
                                        <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                                    </div>
                                    <h5 class="header-title mb-0">Weekly Sales Report</h5>

                                    <div id="weeklysales-collapse" class="collapse pt-3 show">
                                        <div dir="ltr">
                                            <div id="revenue-chart" class="apex-charts" data-colors="#3bc0c3,#1a2942,#d1d7d973"></div>
                                        </div>

                                        <div class="row text-center">
                                            <div class="col">
                                                <p class="text-muted mt-3">Current Week</p>
                                                <h3 class=" mb-0">
                                                    <span>$506.54</span>
                                                </h3>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3">Previous Week</p>
                                                <h3 class=" mb-0">
                                                    <span>$305.25 </span>
                                                </h3>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3">Conversation</p>
                                                <h3 class=" mb-0">
                                                    <span>3.27%</span>
                                                </h3>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3">Customers</p>
                                                <h3 class=" mb-0">
                                                    <span>3k</span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                                        <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                                        <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                                    </div>
                                    <h5 class="header-title mb-0">Yearly Sales Report</h5>

                                    <div id="yearly-sales-collapse" class="collapse pt-3 show">
                                        <div dir="ltr">
                                            <div id="yearly-sales-chart" class="apex-charts" data-colors="#3bc0c3,#1a2942,#d1d7d973"></div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col">
                                                <p class="text-muted mt-3 mb-2">Quarter 1</p>
                                                <h4 class="mb-0">$56.2k</h4>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3 mb-2">Quarter 2</p>
                                                <h4 class="mb-0">$42.5k</h4>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3 mb-2">All Time</p>
                                                <h4 class="mb-0">$102.03k</h4>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->

                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h4 class="fs-22 fw-semibold">69.25%</h4>
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> US Dollar Share</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div id="us-share-chart" class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-4">
                            <!-- Chat-->
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="p-3">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                                            <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                                        </div>
                                        <h5 class="header-title mb-0">Chat</h5>
                                    </div>

                                    <div id="yearly-sales-collapse" class="collapse show">
                                        <div class="chat-conversation mt-2">
                                            <div class="card-body py-0 mb-3" data-simplebar style="height: 322px;">
                                                <ul class="conversation-list">
                                                    <li class="clearfix">
                                                        <div class="chat-avatar">
                                                            <img src="assets/images/users/avatar-5.jpg" alt="male">
                                                            <i>10:00</i>
                                                        </div>
                                                        <div class="conversation-text">
                                                            <div class="ctext-wrap">
                                                                <i>Geneva</i>
                                                                <p>
                                                                    Hello!
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="clearfix odd">
                                                        <div class="chat-avatar">
                                                            <img src="assets/images/users/avatar-1.jpg" alt="Female">
                                                            <i>10:01</i>
                                                        </div>
                                                        <div class="conversation-text">
                                                            <div class="ctext-wrap">
                                                                <i>Thomson</i>
                                                                <p>
                                                                    Hi, How are you? What about our next meeting?
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="clearfix">
                                                        <div class="chat-avatar">
                                                            <img src="assets/images/users/avatar-5.jpg" alt="male">
                                                            <i>10:01</i>
                                                        </div>
                                                        <div class="conversation-text">
                                                            <div class="ctext-wrap">
                                                                <i>Geneva</i>
                                                                <p>
                                                                    Yeah everything is fine
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="clearfix odd">
                                                        <div class="chat-avatar">
                                                            <img src="assets/images/users/avatar-1.jpg" alt="male">
                                                            <i>10:02</i>
                                                        </div>
                                                        <div class="conversation-text">
                                                            <div class="ctext-wrap">
                                                                <i>Thomson</i>
                                                                <p>
                                                                    Wow that's great
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body pt-0">
                                                <form class="needs-validation" novalidate name="chat-form" id="chat-form">
                                                    <div class="row align-items-start">
                                                        <div class="col">
                                                            <input type="text" class="form-control chat-input" placeholder="Enter your text" required>
                                                            <div class="invalid-feedback">
                                                                Please enter your messsage
                                                            </div>
                                                        </div>
                                                        <div class="col-auto d-grid">
                                                            <button type="submit" class="btn btn-danger chat-send waves-effect waves-light">Send</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
    
                                        </div> <!-- end .chat-conversation-->
                                    </div>
                                </div>
                                
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-8">
                            <!-- Todo-->
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="p-3">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                                            <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                                        </div>
                                        <h5 class="header-title mb-0">Projects</h5>
                                    </div>

                                    <div id="yearly-sales-collapse" class="collapse show">

                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Project Name</th>
                                                        <th>Start Date</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Assign</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Velonic Admin v1</td>
                                                        <td>01/01/2015</td>
                                                        <td>26/04/2015</td>
                                                        <td><span class="badge bg-info-subtle text-info">Released</span></td>
                                                        <td>Techzaa Studio</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Velonic Frontend v1</td>
                                                        <td>01/01/2015</td>
                                                        <td>26/04/2015</td>
                                                        <td><span class="badge bg-info-subtle text-info">Released</span></td>
                                                        <td>Techzaa Studio</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Velonic Admin v1.1</td>
                                                        <td>01/05/2015</td>
                                                        <td>10/05/2015</td>
                                                        <td><span class="badge bg-pink-subtle text-pink">Pending</span></td>
                                                        <td>Techzaa Studio</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Velonic Frontend v1.1</td>
                                                        <td>01/01/2015</td>
                                                        <td>31/05/2015</td>
                                                        <td><span class="badge bg-purple-subtle text-purple">Work in Progress</span></td>
                                                        <td>Techzaa Studio</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Velonic Admin v1.3</td>
                                                        <td>01/01/2015</td>
                                                        <td>31/05/2015</td>
                                                        <td><span class="badge bg-warning-subtle text-warning">Coming soon</span></td>
                                                        <td>Techzaa Studio</td>
                                                    </tr>

                                                    <tr>
                                                        <td>6</td>
                                                        <td>Velonic Admin v1.3</td>
                                                        <td>01/01/2015</td>
                                                        <td>31/05/2015</td>
                                                        <td><span class="badge bg-primary-subtle text-primary">Coming soon</span></td>
                                                        <td>Techzaa Studio</td>
                                                    </tr>

                                                    <tr>
                                                        <td>7</td>
                                                        <td>Velonic Admin v1.3</td>
                                                        <td>01/01/2015</td>
                                                        <td>31/05/2015</td>
                                                        <td><span class="badge bg-danger-subtle text-danger">Cool</span></td>
                                                        <td>Techzaa Studio</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>        
                                    </div>
                                </div>                           
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer Start -->
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
    <!-- END wrapper -->

          
    
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Daterangepicker js -->
    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
    
    <!-- Apex Charts js -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Vector Map js -->
    <script src="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Dashboard App js -->
    <script src="assets/js/pages/dashboard.js"></script>


    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

<!-- Mirrored from techzaa.getappui.com/velonic/layouts/layouts-horizontal.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:31:03 GMT -->
</html> 