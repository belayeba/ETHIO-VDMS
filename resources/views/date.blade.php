<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/maptalks/dist/maptalks.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/maptalks/dist/maptalks.min.js"></script>

<!DOCTYPE html>
<html>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Interactions - Distance tool to measure distance</title>
  <style type="text/css">
    html,body{margin:0px;height:100%;width:100%}
    .container{width:50%;height:50%}
  </style>
  <link rel="stylesheet" href="https://unpkg.com/maptalks/dist/maptalks.css">
  <script type="text/javascript" src="https://unpkg.com/maptalks/dist/maptalks.min.js"></script>
  <body>

    <div id="map" class="container"></div>
    <script>

      var map = new maptalks.Map('map', {
        center: [38.763611,9.005401],
        zoom: 20,
        baseLayer: new maptalks.TileLayer('base', {
          urlTemplate: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
          subdomains: ["a","b","c","d"],
          attribution: '&copy; <a href="http://osm.org">OpenStreetMap</a> contributors, &copy; <a href="https://carto.com/">CARTO</a>'
        })
      });

      var distanceTool = new maptalks.DistanceTool({
        'symbol': {
          'lineColor' : '#34495e',
          'lineWidth' : 2
        },
        'vertexSymbol' : {
          'markerType'        : 'ellipse',
          'markerFill'        : '#1bbc9b',
          'markerLineColor'   : '#000',
          'markerLineWidth'   : 3,
          'markerWidth'       : 10,
          'markerHeight'      : 10
        },

        'labelOptions' : {
          'textSymbol': {
            'textFaceName': 'monospace',
            'textFill' : '#fff',
            'textLineSpacing': 1,
            'textHorizontalAlignment': 'right',
            'textDx': 15,
            'markerLineColor': '#b4b3b3',
            'markerFill' : '#000'
          },
          'boxStyle' : {
            'padding' : [6, 2],
            'symbol' : {
              'markerType' : 'square',
              'markerFill' : '#000',
              'markerFillOpacity' : 0.9,
              'markerLineColor' : '#b4b3b3'
            }
          }
        },
        'clearButtonSymbol' :[{
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
          'markerLineColor' : '#fff',
          'markerDx': 20
        }],
        'language' : 'en-US'
      }).addTo(map);

    </script>
  </body>
</html>
