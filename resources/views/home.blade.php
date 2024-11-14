@extends('layouts.navigation')
@section('content')
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.3em 0.5em;
            margin-right: 0.2em;
        }

        .remove-tag {
            cursor: pointer;
            margin-left: 0.3em;
        }

        /* Set map1 container size to fit within the card */
        .map1-container {
            width: 100%;
            height: 300px;
        }

        .map3-container {
                width: 100%;
                height: 300px; /* Adjust height as needed */
            }
        .container{width:100%;height:100%}
        .pane{background:#34495e;line-height:28px;color:#fff;z-index:10;position:absolute;top:20px;right:20px}
        .pane a{display:block;color:#fff;text-align:left;padding:0 10px;min-width:28px;min-height:28px;float:left}
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

                    <div class="col-sm-6">
                        <div class="card card-body">
                            <h4 class="card-title">Map Display</h4>
                            <p class="card-text">Map of Addis Ababa.</p>

                            <!-- Map container inside the card body -->
                            <div id="map1" class="map1-container"></div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-sm-6">
                        <div class="card card-body">
                            <h4 class="card-title">Second map Display</h4>
                            <p class="card-text">A fly over map of Addis ababa.</p>

                             <!-- Map container inside the card body -->
                            <div id="map2" class="map1-container"></div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-sm-6">
                        <div class="card card-body map3-container">
                            <h4 class="card-title">Third map Display</h4>
                            <p class="card-text">A satelite view map of Addis Ababa.</p>

                             <!-- Map container inside the card body -->
                            <div id="map3" class="map3-container"></div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-sm-6">
                        <div class="card card-body map3-container">
                            <h4 class="card-title">Fourth map Display</h4>
                            <p class="card-text">A google map of the institution and Addis Ababa.</p>

                            <iframe 
                              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5430.661768343966!2d38.77176453083739!3d8.990319040092318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b858445d598e9%3A0xbe25e45684bc7620!2sEthiopian%20Artificial%20Intelligence%20Institute!5e0!3m2!1sen!2set!4v1731572808795!5m2!1sen!2set"
                              height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                </div>
            </div>
            
                   

    <!-- Include Maptalks CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/maptalks/dist/maptalks.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/maptalks/dist/maptalks.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/maptalks/dist/maptalks.css">
    <script type="text/javascript" src="https://unpkg.com/maptalks/dist/maptalks.min.js"></script>

    <script type="text/javascript" src="https://unpkg.com/turf@3.0.14/turf.min.js"></script>
    <script>
        // Initialize the map within the map container inside the card
        var map1 = new maptalks.Map('map1', {
            center: [38.763611, 9.005401],
            zoom: 12,
            baseLayer: new maptalks.TileLayer('base', {
                urlTemplate: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
                subdomains: ["a", "b", "c", "d"],
                attribution: '&copy; <a href="http://osm.org">OpenStreetMap</a> contributors, &copy; <a href="https://carto.com/">CARTO</a>'
            })
        });

        var distanceTool = new maptalks.DistanceTool({
            'symbol': {
                'lineColor': '#34495e',
                'lineWidth': 2
            },
            'vertexSymbol': {
                'markerType': 'ellipse',
                'markerFill': '#1bbc9b',
                'markerLineColor': '#000',
                'markerLineWidth': 3,
                'markerWidth': 10,
                'markerHeight': 10
            },
            'labelOptions': {
                'textSymbol': {
                    'textFaceName': 'monospace',
                    'textFill': '#fff',
                    'textLineSpacing': 1,
                    'textHorizontalAlignment': 'right',
                    'textDx': 15,
                    'markerLineColor': '#b4b3b3',
                    'markerFill': '#000'
                },
                'boxStyle': {
                    'padding': [6, 2],
                    'symbol': {
                        'markerType': 'square',
                        'markerFill': '#000',
                        'markerFillOpacity': 0.9,
                        'markerLineColor': '#b4b3b3'
                    }
                }
            },
            'clearButtonSymbol': [{
                'markerType': 'square',
                'markerFill': '#000',
                'markerLineColor': '#b4b3b3',
                'markerLineWidth': 2,
                'markerWidth': 15,
                'markerHeight': 15,
                'markerDx': 20
            }, {
                'markerType': 'x',
                'markerWidth': 10,
                'markerHeight': 10,
                'markerLineColor': '#fff',
                'markerDx': 20
            }],
            'language': 'en-US'
        }).addTo(map1);

      var map2 = new maptalks.Map('map2', {
        center: [38.7578, 9.03], // Addis Ababa coordinates
        zoom: 15,
        baseLayer: new maptalks.TileLayer('base', {
          urlTemplate: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
          subdomains: ["a", "b", "c", "d"],
          attribution: '&copy; <a href="http://osm.org">OpenStreetMap</a> contributors, &copy; <a href="https://carto.com/">CARTO</a>'
        })
      });

      changeView();

      function changeView() {
        map2.animateTo({
          center: [38.7578, 9.03], // Starting point: Addis Ababa
          zoom: 13,
          pitch: 0,
          bearing: 20
        }, {
          duration: 5000
        });
        setTimeout(function () {
          map2.animateTo({
            center: [38.76, 9.04], // Another view near Addis Ababa for a smooth transition
            zoom: 18,
            pitch: 65,
            bearing: 360
          }, {
            duration: 7000
          });
        }, 7000);
      }

      var center = new maptalks.Coordinate(38.7468, 9.0036);
      var map3 = new maptalks.Map('map3', {
        center: center,
        zoom: 15,
        seamlessZoom: true,
        pitch: 65,
        // centerCross: true,
        baseLayer: new maptalks.TileLayer('base', {
          urlTemplate:
            'https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
          subdomains: ['a', 'b', 'c', 'd'],
          attribution: '&copy; <a href="https://www.esri.com/en-us/home">esri</a>'
        })
      });

      var layer = new maptalks.VectorLayer('layer', {
        hitDetect: true,
        geometryEvents: true
      }).addTo(map3);

      var line = new maptalks.LineString(coordiantes, {
        symbol: {
          lineWidth: 5,
          lineColor: 'yellow'
        }
      });
      line.addTo(layer);
      map.setCenter(line.getCoordinates()[0]);
      var point = new maptalks.Marker(coordiantes[0], {
        symbol: {
          markerFile: markerFile,
          markerWidth: 50,
          markerHeight: 50
        }
      }).addTo(layer);
    
    </script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    @endsection
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
