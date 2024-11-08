<!DOCTYPE html>
<html lang="en">
@include('layouts.main-link')
@include('layouts.header')
@include('layouts.sidebar')
@include('layouts.setting')


<body>
    <!-- Begin page -->
    <div class="wrapper">


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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active">Form Advanced</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Form Advanced</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Select2</h4>
                                    <p class="text-muted mb-0">Select2 gives you a customizable select box with support
                                        for searching, tagging, remote data sets, infinite scrolling, and many other
                                        highly used options.</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="mb-1 fw-bold text-muted">Single Select</p>
                                            <p class="text-muted fs-14">
                                                Select2 can take a regular select box like this...
                                            </p>

                                            <select class="form-control select2" data-toggle="select2">
                                                <option>Select</option>
                                                <optgroup label="Alaskan/Hawaiian Time Zone">
                                                    <option value="AK">Alaska</option>
                                                    <option value="HI">Hawaii</option>
                                                </optgroup>
                                                <optgroup label="Pacific Time Zone">
                                                    <option value="CA">California</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="WA">Washington</option>
                                                </optgroup>
                                                <optgroup label="Mountain Time Zone">
                                                    <option value="AZ">Arizona</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="WY">Wyoming</option>
                                                </optgroup>
                                                <optgroup label="Central Time Zone">
                                                    <option value="AL">Alabama</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="WI">Wisconsin</option>
                                                </optgroup>
                                                <optgroup label="Eastern Time Zone">
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WV">West Virginia</option>
                                                </optgroup>
                                            </select>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6">
                                            <p class="mb-1 fw-bold text-muted">Multiple Select</p>
                                            <p class="text-muted fs-14">
                                                Select2 can take a regular select box like this...
                                            </p>

                                            <select class="select2 form-control select2-multiple" data-toggle="select2"
                                                multiple="multiple" data-placeholder="Choose ...">
                                                <optgroup label="Alaskan/Hawaiian Time Zone">
                                                    <option value="AK">Alaska</option>
                                                    <option value="HI">Hawaii</option>
                                                </optgroup>
                                                <optgroup label="Pacific Time Zone">
                                                    <option value="CA">California</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="WA">Washington</option>
                                                </optgroup>
                                                <optgroup label="Mountain Time Zone">
                                                    <option value="AZ">Arizona</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="WY">Wyoming</option>
                                                </optgroup>
                                                <optgroup label="Central Time Zone">
                                                    <option value="AL">Alabama</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="WI">Wisconsin</option>
                                                </optgroup>
                                                <optgroup label="Eastern Time Zone">
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WV">West Virginia</option>
                                                </optgroup>
                                            </select>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Date Range Picker</h4>
                                    <p class="text-muted mb-0">
                                        A JavaScript component for choosing date ranges, dates and times.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!-- Date Range -->
                                            <div class="mb-3">
                                                <label class="form-label">Date Range</label>
                                                <input type="text" class="form-control date" id="singledaterange"
                                                    data-toggle="date-picker" data-cancel-class="btn-warning">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Date Range Picker With Times -->
                                            <div class="mb-3">
                                                <label class="form-label">Date Range Picker With Times</label>
                                                <input type="text" class="form-control date" id="daterangetime"
                                                    data-toggle="date-picker" data-time-picker="true"
                                                    data-locale="{'format': 'DD/MM hh:mm A'}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!-- Single Date Picker -->
                                            <div>
                                                <label class="form-label">Single Date Picker</label>
                                                <input type="text" class="form-control date" id="birthdatepicker"
                                                    data-toggle="date-picker" data-single-date-picker="true">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Predefined Date Ranges -->
                                            <div>
                                                <label class="form-label">Predefined Date Ranges</label>
                                                <div id="reportrange" class="form-control"
                                                    data-toggle="date-picker-range" data-target-display="#selectedValue"
                                                    data-cancel-class="btn-light">
                                                    <i class="ri-calendar-2-line"></i>&nbsp;
                                                    <span id="selectedValue"></span> <i
                                                        class="ri-arrow-down-s-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Bootstrap Datepicker</h4>
                                    <p class="text-muted mb-0">
                                        Bootstrap-datepicker provides a flexible datepicker widget in the Bootstrap
                                        style.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker1">
                                                <label class="form-label">Date Picker</label>
                                                <input type="text" class="form-control" placeholder="Select Date"
                                                    data-provide="datepicker" data-date-today-highlight="true"
                                                    data-date-container="#datepicker1">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker2">
                                                <label class="form-label">Date View</label>
                                                <input type="text" class="form-control" placeholder="Select Date"
                                                    data-provide="datepicker" data-date-format="d-M-yyyy"
                                                    data-date-container="#datepicker2">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker3">
                                                <label class="form-label">Multi Datepicker</label>
                                                <input type="text" class="form-control" placeholder="Select Date"
                                                    data-provide="datepicker" data-date-multidate="true"
                                                    data-date-container="#datepicker3">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker4">
                                                <label class="form-label">Autoclose</label>
                                                <input type="text" class="form-control" placeholder="Select Date"
                                                    data-provide="datepicker" data-date-autoclose="true"
                                                    data-date-container="#datepicker4">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker5">
                                                <label class="form-label">Month View</label>
                                                <input type="text" class="form-control" placeholder="Select Month"
                                                    data-provide="datepicker" data-date-format="MM yyyy"
                                                    data-date-min-view-mode="1" data-date-container="#datepicker5">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3 position-relative" id="datepicker6">
                                                <label class="form-label">Year View</label>
                                                <input type="text" class="form-control" placeholder="Select Year"
                                                    data-provide="datepicker" data-date-min-view-mode="2"
                                                    data-date-container="#datepicker6">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Inline Datepicker</label>
                                                <div data-provide="datepicker-inline"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Flatpickr - Date picker</h4>
                                    <p class="text-muted mb-0">A lightweight and powerful datetimepicker</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Basic</label>
                                                <input type="text" id="basic-datepicker" class="form-control"
                                                    placeholder="Basic datepicker">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Date & Time</label>
                                                <input type="text" id="datetime-datepicker" class="form-control"
                                                    placeholder="Date and Time">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Human-friendly Dates</label>
                                                <input type="text" id="humanfd-datepicker" class="form-control"
                                                    placeholder="October 9, 2018">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">MinDate and MaxDate</label>
                                                <input type="text" id="minmax-datepicker" class="form-control"
                                                    placeholder="mindate - maxdate">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Disabling dates</label>
                                                <input type="text" id="disable-datepicker" class="form-control"
                                                    placeholder="Disabling dates">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Selecting multiple dates</label>
                                                <input type="text" id="multiple-datepicker" class="form-control"
                                                    placeholder="Multiple dates">
                                            </div>

                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label class="form-label">Selecting multiple dates - Conjunction</label>
                                                <input type="text" id="conjunction-datepicker" class="form-control"
                                                    placeholder="2018-10-10 :: 2018-10-11">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Range Calendar</label>
                                                <input type="text" id="range-datepicker" class="form-control"
                                                    placeholder="2018-10-03 to 2018-10-10">
                                            </div>

                                            <div>
                                                <label class="form-label">Inline Calendar</label>
                                                <input type="text" id="inline-datepicker" class="form-control"
                                                    placeholder="Inline calendar">
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Flatpickr - Time Picker </h4>
                                    <p class="text-muted mb-0">A lightweight and powerful datetimepicker</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Default Time Picker</label>
                                                <div class="input-group">
                                                    <input id="basic-timepicker" type="text" class="form-control"
                                                        placeholder="Basic timepicker">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                </div>
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label">24-hour Time Picker</label>
                                                <div class="input-group">
                                                    <input id="24hours-timepicker" type="text" class="form-control"
                                                        placeholder="16:21">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label class="form-label">Time Picker w/ Limits</label>
                                                <div class="input-group">
                                                    <input id="minmax-timepicker" type="text" class="form-control"
                                                        placeholder="Limits">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                </div>
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label">Preloading Time</label>
                                                <div class="input-group">
                                                    <input id="preloading-timepicker" type="text" class="form-control"
                                                        placeholder="Pick a time">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Input Masks</h4>
                                    <p class="text-muted mb-0">
                                        A jQuery Plugin to make masks on form fields and HTML elements.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form action="#">
                                                <div class="mb-3">
                                                    <label class="form-label">Date</label>
                                                    <input type="text" class="form-control" placeholder="Enter date"
                                                        data-toggle="input-mask" data-mask-format="00/00/0000">
                                                    <span class="fs-13 text-muted">e.g "DD/MM/YYYY"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hour</label>
                                                    <input type="text" class="form-control" placeholder="Enter time"
                                                        data-toggle="input-mask" data-mask-format="00:00:00">
                                                    <span class="fs-13 text-muted">e.g "HH:MM:SS"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Date & Hour</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter date & time" data-toggle="input-mask"
                                                        data-mask-format="00/00/0000 00:00:00">
                                                    <span class="fs-13 text-muted">e.g "DD/MM/YYYY HH:MM:SS"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">ZIP Code</label>
                                                    <input type="text" class="form-control" placeholder="Enter zip code"
                                                        data-toggle="input-mask" data-mask-format="00000-000">
                                                    <span class="fs-13 text-muted">e.g "xxxxx-xxx"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Crazy Zip Code</label>
                                                    <input type="text" class="form-control" placeholder="Enter zip code"
                                                        data-toggle="input-mask" data-mask-format="0-00-00-00">
                                                    <span class="fs-13 text-muted">e.g "x-xx-xx-xx"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Money</label>
                                                    <input type="text" class="form-control" placeholder="Enter money"
                                                        data-toggle="input-mask"
                                                        data-mask-format="000.000.000.000.000,00" data-reverse="true">
                                                    <span class="fs-13 text-muted">e.g "Your money"</span>
                                                </div>
                                                <div>
                                                    <label class="form-label">Money 2</label>
                                                    <input type="text" class="form-control" placeholder="Enter money"
                                                        data-toggle="input-mask" data-mask-format="#.##0,00"
                                                        data-reverse="true">
                                                    <span class="fs-13 text-muted">e.g "#.##0,00"</span>
                                                </div>

                                            </form>
                                        </div> <!-- end col -->

                                        <div class="col-md-6">
                                            <form action="#">
                                                <div class="mb-3">
                                                    <label class="form-label">Telephone</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter telephone" data-toggle="input-mask"
                                                        data-mask-format="0000-0000">
                                                    <span class="fs-13 text-muted">e.g "xxxx-xxxx"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Telephone with Code Area</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter telephone" data-toggle="input-mask"
                                                        data-mask-format="(00) 0000-0000">
                                                    <span class="fs-13 text-muted">e.g "(xx) xxxx-xxxx"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">US Telephone</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter US telephone" data-toggle="input-mask"
                                                        data-mask-format="(000) 000-0000">
                                                    <span class="fs-13 text-muted">e.g "(xxx) xxx-xxxx"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">São Paulo Celphones</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter telephone" data-toggle="input-mask"
                                                        data-mask-format="(00) 00000-0000">
                                                    <span class="fs-13 text-muted">e.g "(xx) xxxxx-xxxx"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">CPF</label>
                                                    <input type="text" class="form-control" placeholder="Enter CPF"
                                                        data-toggle="input-mask" data-mask-format="000.000.000-00"
                                                        data-reverse="true">
                                                    <span class="fs-13 text-muted">e.g "xxx.xxx.xxxx-xx"</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">CNPJ</label>
                                                    <input type="text" class="form-control" placeholder="Enter CNPJ"
                                                        data-toggle="input-mask" data-mask-format="00.000.000/0000-00"
                                                        data-reverse="true">
                                                    <span class="fs-13 text-muted">e.g "xx.xxx.xxx/xxxx-xx"</span>
                                                </div>
                                                <div>
                                                    <label class="form-label">IP Address</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter IP address" data-toggle="input-mask"
                                                        data-mask-format="099.099.099.099" data-reverse="true">
                                                    <span class="fs-13 text-muted">e.g "xxx.xxx.xxx.xxx"</span>
                                                </div>
                                            </form>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Bootstrap Touchspin</h4>
                                    <p class="text-muted mb-0">
                                        A mobile and touch friendly input spinner component for Bootstrap.
                                        Specify attribute <code>data-toggle="touchspin"</code> and your input would
                                        be
                                        conveterted into touch friendly spinner.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Using data attributes</label>
                                                <input data-toggle="touchspin" type="text" value="55">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Example with postfix (large)</label>
                                                <input data-toggle="touchspin" value="18.20" type="text" data-step="0.1"
                                                    data-decimals="2" data-bts-postfix="%">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">With prefix</label>
                                                <input data-toggle="touchspin" type="text" data-bts-prefix="$">
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label">Change button class</label>
                                                <input data-toggle="touchspin" value="77" type="text"
                                                    data-bts-button-down-class="btn btn-danger"
                                                    data-bts-button-up-class="btn btn-info">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label class="form-label">Init with empty value:</label>
                                                <input data-toggle="touchspin" type="text">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Max value - (Default value 100)</label>
                                                <input data-toggle="touchspin" data-bts-max="500" value="128"
                                                    data-btn-vertical="true" type="text">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">With prefix and postfix button</label>
                                                <input data-toggle="touchspin" data-bts-prefix="A Button"
                                                    data-bts-prefix-extra-class="btn btn-light"
                                                    data-bts-postfix="A Button"
                                                    data-bts-postfix-extra-class="btn btn-light" type="text">
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Bootstrap Maxlength</h4>
                                    <p class="text-muted mb-0">
                                        Uses the HTML5 attribute "maxlength" to work. Just specify
                                        <code>data-toggle="maxlength"</code> attribute
                                        to have maxlength indication on any input.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Default usage</label>
                                                <p class="text-muted fs-13">
                                                    The badge will show up by default when the remaining chars are 10 or
                                                    less:
                                                </p>
                                                <input type="text" class="form-control" placeholder="Max 25"
                                                    maxlength="25" data-toggle="maxlength">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Threshold value</label>
                                                <p class="text-muted fs-13">
                                                    Satrt displaying the indication when reached to some threshhold.
                                                    Specift the data attribute <code>threshold</code>. E.g.
                                                    <code>data-threshold="12"</code>
                                                </p>
                                                <input type="text" class="form-control" placeholder="Max 25"
                                                    maxlength="25" data-toggle="maxlength" data-threshold="12">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label class="form-label">Position</label>
                                                <p class="text-muted fs-13">
                                                    All you need to do is specify the data attribute
                                                    <code>placement</code>. The possible positions are left, top, right,
                                                    bottom-right, top-right, top-left,
                                                    bottom, bottom-left and centered-right. If none is specified, the
                                                    positioning will be defauted to 'bottom'.
                                                    E.g. <code>data-placement="top"</code>
                                                </p>
                                                <input type="text" class="form-control" placeholder="Max 25"
                                                    maxlength="25" data-toggle="maxlength" data-placement="top">
                                            </div>

                                            <div>
                                                <label class="form-label">Textareas</label>
                                                <p class="text-muted fs-13">
                                                    Bootstrap maxlength supports textarea as well as inputs. Even on old
                                                    IE.
                                                </p>
                                                <textarea data-toggle="maxlength" class="form-control" maxlength="225"
                                                    rows="3"
                                                    placeholder="This textarea has a limit of 225 chars."></textarea>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Timepicker</h4>
                                    <p class="text-muted mb-0">
                                        Easily select a time for a text input using your mouse or keyboards arrow keys.
                                        Specify attribute <code>data-toggle="timepicker"</code>
                                        and you would have nice timepicker input element.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Default Time Picker</label>
                                                <div class="input-group" id="timepicker-input-group1">
                                                    <input id="timepicker" type="text" class="form-control"
                                                        data-provide="timepicker">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                </div>
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label">24 Hour Mode Time Picker E.g.
                                                    <code>data-show-meridian="false"</code></label>
                                                <div class="input-group" id="timepicker-input-group2">
                                                    <input id="timepicker2" type="text" class="form-control"
                                                        data-provide='timepicker' data-show-meridian="false">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-0">
                                                <label class="form-label">Specify a step for the minute field E.g.
                                                    <code>data-minute-step="5"</code></label>
                                                <div class="input-group" id="timepicker-input-group3">
                                                    <input id="timepicker3" type="text" class="form-control"
                                                        data-provide='timepicker' data-minute-step="5">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Typeahead</h4>
                                    <p class="text-muted mb-0">
                                        Typeahead.js is a fast and fully-featured autocomplete library.
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">The Basics</label>
                                                <input type="text" class="form-control" data-provide="typeahead"
                                                    id="the-basics" placeholder="Basic Example">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label class="form-label">Bloodhound (Suggestion Engine)</label>
                                                <input id="bloodhound" class="form-control" type="text"
                                                    placeholder="States of USA">
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Prefetch</label>
                                                <input type="text" class="form-control" data-provide="typeahead"
                                                    id="prefetch" placeholder="States of USA">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label class="form-label">Remote</label>
                                                <input type="text" class="form-control" data-provide="typeahead"
                                                    id="remote" placeholder="States of USA">
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Custom Templates</label>
                                                <input id="custom-templates" class="form-control" type="text"
                                                    placeholder="States of USA">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label class="form-label">Default Suggestions</label>
                                                <input type="text" class="form-control" data-provide="typeahead"
                                                    id="default-suggestions">
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-0">
                                                <label class="form-label">Multiple Datasets</label>
                                                <input type="text" class="form-control" data-provide="typeahead"
                                                    id="multiple-datasets">
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->


                </div> <!-- container -->

            </div> <!-- content -->

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

    <!--  Select2 Plugin Js -->
    <script src="assets/vendor/select2/js/select2.min.js"></script>

    <!-- Daterangepicker Plugin js -->
    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin js -->
    <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- Bootstrap Timepicker Plugin js -->
    <script src="assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

    <!-- Input Mask Plugin js -->
    <script src="assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>

    <!-- Bootstrap Touchspin Plugin js -->
    <script src="assets/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <!-- Bootstrap Maxlength Plugin js -->
    <script src="assets/vendor/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

    <!-- Typehead Plugin js -->
    <script src="assets/vendor/handlebars/handlebars.min.js"></script>
    <script src="assets/vendor/typeahead.js/typeahead.bundle.min.js"></script>

    <!-- Flatpickr Timepicker Plugin js -->
    <script src="assets/vendor/flatpickr/flatpickr.min.js"></script>

    <!-- Typehead Demo js -->
    <script src="assets/js/pages/typehead.init.js"></script>

    <!-- Timepicker Demo js -->
    <script src="assets/js/pages/timepicker.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


<!-- Mirrored from techzaa.getappui.com/velonic/layouts/form-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Oct 2023 02:30:18 GMT -->
</html>