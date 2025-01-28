@extends('layouts.navigation')
@section('content')
    <style>
        html,body{margin:0px;height:100%;width:100%}
        .container{width:100%;height:100%}
    </style>

    <div class="content-page">
        <div class="content">

            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Error - </strong> {!! session('error_message') !!}
                </div>
            @endif

            @if (Session::has('success_message'))
                <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong> Success- </strong> {!! session('success_message') !!}
                </div>
            @endif

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                  <div class="row">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-secondary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="ri-questionnaire-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Temporary Requests">Total Temporary</br> Request</h6>
                                <h2 class="my-2">{{$tempReq}}</h2>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-primary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-p2p-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Permanent Request">Total Permanent</br> Request</h6>
                                <h2 class="my-2">{{$permReq}}</h2>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-secondary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-taxi-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Vehicles">Total </br>Vehicle</h6>
                                <h2 class="my-2">{{$vehicles}}</h2>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-primary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-user-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Customers">Total </br>Users</h6>
                                <h2 class="my-2">{{$users}}</h2>
                               </div>
                        </div>
                    </div> <!-- end col-->
                </div>

                    <div class="col-sm-12">
                        <div class="card card-body" >
                            <h4 class="card-title"> @lang('messages.Map Display')</h4>
                            {{-- <p class="card-text">Map of Addis Ababa.</p> --}}

                            <!-- Map container inside the card body -->
                            {{-- <div id="map1" class="map1-container" style="height: 100vh;"></div> --}}
                            <div id="map" class="container" style="height: 70vh;"></div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                </div>
            </div>
            
                   

    <!-- Include Maptalks CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/maptalks/dist/maptalks.css">
    <script type="text/javascript" src="https://unpkg.com/maptalks/dist/maptalks.min.js"></script>
    {{-- <link rel="stylesheet" href="https://unpkg.com/maptalks/dist/maptalks.css">
    <script type="text/javascript" src="https://unpkg.com/maptalks/dist/maptalks.min.js"></script>

    <script type="text/javascript" src="https://unpkg.com/turf@3.0.14/turf.min.js"></script> --}}
    <script>
        // Initialize the map within the map container inside the card
        var map = new maptalks.Map('map', {
        center: [38.763611, 9.005401],
        zoom: 7,
        baseLayer: new maptalks.TileLayer('base', {
          urlTemplate: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
          subdomains: ["a","b","c","d"],
          attribution: '&copy; <a href="http://osm.org">OpenStreetMap</a> contributors, &copy; <a href="https://carto.com/">CARTO</a>'
        })
      });

      var layer = new maptalks.VectorLayer('vector').addTo(map);

      var marker = new maptalks.Marker(
        [38.7667302, 8.988853],
        {
          'properties' : {
            'name' : 'A-1-22112'
          },
          symbol : [
            {
              'markerFile'   : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSq_f7BQdyTmLTF8rCF8Y4P4A2GprGVFjUZbA&s',
              'markerWidth'  : 28,
              'markerHeight' : 40,
              'markerDx'     : 0,
              'markerDy'     : 0,
              'markerOpacity': 1
            },
            {
              'textFaceName' : 'sans-serif',
              'textName' : '{name}',
              'textSize' : 14,
              'textDy'   : 24
            }
          ]
        }
      ).addTo(layer);




      var marker = new maptalks.Marker(
        [38.7490906, 9.018345],
        {
          'properties' : {
            'name' : 'A-2-27633'
          },
          symbol : [
            {
              'markerFile'   : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSq_f7BQdyTmLTF8rCF8Y4P4A2GprGVFjUZbA&s',
              'markerWidth'  : 28,
              'markerHeight' : 40,
              'markerDx'     : 0,
              'markerDy'     : 0,
              'markerOpacity': 1
            },
            {
              'textFaceName' : 'sans-serif',
              'textName' : '{name}',
              'textSize' : 14,
              'textDy'   : 24
            }
          ]
        }
      ).addTo(layer);

      var marker = new maptalks.Marker(
        [39.2232378, 8.5339425],
        {
          'properties' : {
            'name' : 'B-3-23343'
          },
          symbol : [
            {
              'markerFile'   : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTs9o-Le0yd9rLvrLp4S5A81R0CUWUJUvmx-Q&s',
              'markerWidth'  : 28,
              'markerHeight' : 40
            },
            {
              'textFaceName' : 'sans-serif',
              'textName' : '{name}',
              'textSize' : 14,
              'textDy'   : 24,
              'markerDx'     : 0,
              'markerDy'     : 0,
              'markerOpacity': 1
            }
          ]
        }
      ).addTo(layer);
      
    </script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    @endsection
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
