<!DOCTYPE html>
<html>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Animation - map-view-follow animation</title>
  <style type="text/css">
    html,body{margin:0px;height:50%;width:50%}
    .container{width:100%;height:100%}
    .pane{background:#34495e;line-height:28px;color:#fff;z-index:10;position:absolute;top:20px;right:20px}
    .pane a{display:block;color:#fff;text-align:left;padding:0 10px;min-width:28px;min-height:28px;float:left}
  </style>
  <link rel="stylesheet" href="https://unpkg.com/maptalks/dist/maptalks.css">
  <script type="text/javascript" src="https://unpkg.com/maptalks/dist/maptalks.min.js"></script>
  <body>
    <script type="text/javascript" src="https://unpkg.com/turf@3.0.14/turf.min.js"></script>
    <div id="map" class="container"></div>

    <script>
      var center = new maptalks.Coordinate(118.846825, 32.046534);
      var map = new maptalks.Map('map', {
        center: center,
        zoom: 18,
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
      }).addTo(map);

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
  </body>
</html>