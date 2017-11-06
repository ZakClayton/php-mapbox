<?php

require_once "../../vendor/autoload.php";

use SSD\DotEnv\DotEnv;
use ZakClayton\Mapbox\MapboxApi;
use ZakClayton\Mapbox\Exception\MapboxException;

$query = $_POST['query'];
if(empty($query)) {
    return print('Please enter search query.');
}

$dotenv = new DotEnv([
    __DIR__ . '/.env'
]);
$dotenv->load();
$dotenv->required([
    'MAPBOX_ACCESS_TOKEN'
]);

$mapbox       = new MapboxApi(getenv('MAPBOX_ACCESS_TOKEN'));
$geoCodingApi = $mapbox->createGeoCodingApi($query, array('type'=>'address','limit'=>1));
$json         = $geoCodingApi->getJson();

?>
<!doctype html>
<head>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.40.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.40.1/mapbox-gl.css' rel='stylesheet' />
    <style>
      * { box-sizing: border-box; }
      body { text-align: center; padding: 150px; }
      h1 { font-size: 50px; }
      body { font: 20px Helvetica, sans-serif; color: #333; }
      article { display: block; text-align: left; width: 650px; margin: 0 auto; }
      a { color: #dc8100; text-decoration: none; }
      a:hover { color: #333; text-decoration: none; }
      .form-group { margin-bottom: 5px; }
      input { width: 100%; padding: 7px 5px; }
      button { padding: 7px 10px; float: right; }

      #map {
          width: 100%;
          height: 100vh;
        }

        .bounce-a .pin {
          width: 30px;
          height: 30px;
          -webkit-border-radius: 50% 50% 50% 0;
          border-radius: 50% 50% 50% 0;
          background: #89849b;
          position: absolute;
          -webkit-transform: rotate(-45deg);
          -moz-transform: rotate(-45deg);
          -o-transform: rotate(-45deg);
          -ms-transform: rotate(-45deg);
          transform: rotate(-45deg);
          left: 50%;
          top: 50%;
          margin: -20px 0 0 -20px;
          -webkit-animation-name: bounce-a;
          -moz-animation-name: bounce-a;
          -o-animation-name: bounce-a;
          -ms-animation-name: bounce-a;
          animation-name: bounce-a;
          -webkit-animation-fill-mode: both;
          -moz-animation-fill-mode: both;
          -o-animation-fill-mode: both;
          -ms-animation-fill-mode: both;
          animation-fill-mode: both;
          -webkit-animation-duration: 1s;
          -moz-animation-duration: 1s;
          -o-animation-duration: 1s;
          -ms-animation-duration: 1s;
          animation-duration: 1s;
        }

        .pin:after {
          content: '';
          width: 14px;
          height: 14px;
          margin: 8px 0 0 8px;
          background: #2f2f2f;
          position: absolute;
          -webkit-border-radius: 50%;
          border-radius: 50%;
        }

        .pulse {
          background: rgba(0, 0, 0, 0.2);
          -webkit-border-radius: 50%;
          border-radius: 50%;
          height: 14px;
          width: 14px;
          position: absolute;
          left: 50%;
          top: 50%;
          margin: 11px 0px 0px -12px;
          -webkit-transform: rotateX(55deg);
          -moz-transform: rotateX(55deg);
          -o-transform: rotateX(55deg);
          -ms-transform: rotateX(55deg);
          transform: rotateX(55deg);
          z-index: -2;
        }

        .pulse:after {
          content: "";
          -webkit-border-radius: 50%;
          border-radius: 50%;
          height: 40px;
          width: 40px;
          position: absolute;
          margin: -13px 0 0 -13px;
          -webkit-animation: pulsate 1s ease-out;
          -moz-animation: pulsate 1s ease-out;
          -o-animation: pulsate 1s ease-out;
          -ms-animation: pulsate 1s ease-out;
          animation: pulsate 1s ease-out;
          -webkit-animation-iteration-count: infinite;
          -moz-animation-iteration-count: infinite;
          -o-animation-iteration-count: infinite;
          -ms-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
          opacity: 0;
          -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
          filter: alpha(opacity=0);
          -webkit-box-shadow: 0 0 1px 2px #89849b;
          box-shadow: 0 0 1px 2px #89849b;
          -webkit-animation-delay: 1.1s;
          -moz-animation-delay: 1.1s;
          -o-animation-delay: 1.1s;
          -ms-animation-delay: 1.1s;
          animation-delay: 1.1s;
        }

        @-moz-keyframes pulsate {
          0% {
            -webkit-transform: scale(0.1, 0.1);
            -moz-transform: scale(0.1, 0.1);
            -o-transform: scale(0.1, 0.1);
            -ms-transform: scale(0.1, 0.1);
            transform: scale(0.1, 0.1);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
          50% {
            opacity: 1;
            -ms-filter: none;
            filter: none;
          }
          100% {
            -webkit-transform: scale(1.2, 1.2);
            -moz-transform: scale(1.2, 1.2);
            -o-transform: scale(1.2, 1.2);
            -ms-transform: scale(1.2, 1.2);
            transform: scale(1.2, 1.2);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
        }

        @-webkit-keyframes pulsate {
          0% {
            -webkit-transform: scale(0.1, 0.1);
            -moz-transform: scale(0.1, 0.1);
            -o-transform: scale(0.1, 0.1);
            -ms-transform: scale(0.1, 0.1);
            transform: scale(0.1, 0.1);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
          50% {
            opacity: 1;
            -ms-filter: none;
            filter: none;
          }
          100% {
            -webkit-transform: scale(1.2, 1.2);
            -moz-transform: scale(1.2, 1.2);
            -o-transform: scale(1.2, 1.2);
            -ms-transform: scale(1.2, 1.2);
            transform: scale(1.2, 1.2);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
        }

        @-o-keyframes pulsate {
          0% {
            -webkit-transform: scale(0.1, 0.1);
            -moz-transform: scale(0.1, 0.1);
            -o-transform: scale(0.1, 0.1);
            -ms-transform: scale(0.1, 0.1);
            transform: scale(0.1, 0.1);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
          50% {
            opacity: 1;
            -ms-filter: none;
            filter: none;
          }
          100% {
            -webkit-transform: scale(1.2, 1.2);
            -moz-transform: scale(1.2, 1.2);
            -o-transform: scale(1.2, 1.2);
            -ms-transform: scale(1.2, 1.2);
            transform: scale(1.2, 1.2);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
        }

        @keyframes pulsate {
          0% {
            -webkit-transform: scale(0.1, 0.1);
            -moz-transform: scale(0.1, 0.1);
            -o-transform: scale(0.1, 0.1);
            -ms-transform: scale(0.1, 0.1);
            transform: scale(0.1, 0.1);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
          50% {
            opacity: 1;
            -ms-filter: none;
            filter: none;
          }
          100% {
            -webkit-transform: scale(1.2, 1.2);
            -moz-transform: scale(1.2, 1.2);
            -o-transform: scale(1.2, 1.2);
            -ms-transform: scale(1.2, 1.2);
            transform: scale(1.2, 1.2);
            opacity: 0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
          }
        }

        @-webkit-keyframes bounce-a {
          0% {
            opacity: 0;
            transform: translateY(-2000px) rotate(-45deg);
          }
          60% {
            opacity: 1;
            transform: translateY(30px) rotate(-45deg);
          }
          80% {
            transform: translateY(-10px) rotate(-45deg);
          }
          100% {
            transform: translateY(0) rotate(-45deg);
          }
        }

        @-webkit-keyframes bounce-b {
          0% {
            opacity: 0;
            transform: translateY(-2000px) rotate(-45deg);
          }
          40% {
            opacity: .25;
            transform: translateY(-1000px) rotate(-45deg);
          }
          60% {
            opacity: .35;
            transform: translateY(-500px) rotate(-45deg);
          }
          70% {
            opacity: 1;
            transform: translateY(-30px) rotate(-45deg);
          }
          80% {
            transform: translateY(-10px) rotate(-45deg);
          }
          100% {
            transform: translateY(0) rotate(-45deg);
          }
        }

        @-webkit-keyframes bounce-c {
          0% {
            opacity: 0;
            transform: translateY(-3000px) rotate(-45deg);
          }
          40% {
            opacity: .25;
            transform: translateY(-2000px) rotate(-45deg);
          }
          60% {
            opacity: .35;
            transform: translateY(-1000px) rotate(-45deg);
          }
          70% {
            opacity: 1;
            transform: translateY(-500px) rotate(-45deg);
          }
          80% {
            transform: translateY(-10px) rotate(-45deg);
          }
          100% {
            transform: translateY(0) rotate(-45deg);
          }
        }

    </style>
</head>

<article>
    <div class="map mapbox" id="mapBox" style="width: 100%; height: 600px;"></div>
</article>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoicG13Y29tbXVuaWNhdGlvbnMiLCJhIjoiY2o4NXJudDdtMGkzejJ3bXA0YTgzaXJtbiJ9.TXHNSEROw-Wm-BhMlOPyRQ';
    var geojson = <?php echo $json; ?>;

    var map = new mapboxgl.Map({
        container: 'mapBox',
        style: 'mapbox://styles/pmwcommunications/cj85srmw51zrp2rnqbpwrtyxy',   // Create new style on Mapbox
        center: [-100.486052, 37.830348],
        zoom: 0,
        scrollZoom: false,
    });

    map.addControl(new mapboxgl.NavigationControl());

    geojson.features.forEach(function(marker) {
        var el    = document.createElement('div');
        var pin   = document.createElement('div');
        var pulse = document.createElement('div');
        pin.className = 'pin';
        pulse.className = 'pulse';
        el.className = 'marker bounce-a';
        el.appendChild(pin);
        el.appendChild(pulse);

        el.addEventListener('click', function() {
            window.alert('Marker Click Event');
        });

        // add marker to map
        new mapboxgl.Marker(el, {offset: [0, -15]})
            .setLngLat(marker.geometry.coordinates)
            .addTo(map);
    });

</script>
