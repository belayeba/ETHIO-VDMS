<!DOCTYPE html>
<html>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Geometry Styles - Image marker with texts</title>
  <style type="text/css">
    html,body{margin:0px;height:100%;width:100%}
    .container{width:100%;height:100%}
  </style>
  <link rel="stylesheet" href="https://unpkg.com/maptalks/dist/maptalks.css">
  <script type="text/javascript" src="https://unpkg.com/maptalks/dist/maptalks.min.js"></script>
  <body>

    <div id="map" class="container"></div>
    <script>

      var map = new maptalks.Map('map', {
        center: [-0.113049, 51.49856],
        zoom: 14,
        baseLayer: new maptalks.TileLayer('base', {
          urlTemplate: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
          subdomains: ["a","b","c","d"],
          attribution: '&copy; <a href="http://osm.org">OpenStreetMap</a> contributors, &copy; <a href="https://carto.com/">CARTO</a>'
        })
      });

      var layer = new maptalks.VectorLayer('vector').addTo(map);

      var marker = new maptalks.Marker(
        [-0.113049, 51.49856],
        {
          'properties' : {
            'name' : 'Hello\nMapTalks'
          },
          symbol : [
            {
              'markerFile'   : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLmj4jI0hgE5tR38ss1MoHySGGetdwWzWsow&s',
              'markerWidth'  : 28,
              'markerHeight' : 40
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
        [-0.113049, 51.49444],
        {
          'properties' : {
            'name' : 'Hello\nMapTalks'
          },
          symbol : [
            {
              'markerFile'   : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp2HlFwrCQU2hQA-2k9pJaLz4GQD_5ReO-pg&s',
              'markerWidth'  : 28,
              'markerHeight' : 40
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


    </script>
  </body>
</html>