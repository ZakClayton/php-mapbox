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

$mapbox = new MapboxApi(getenv('MAPBOX_ACCESS_TOKEN'));
$geoCodingApi = $mapbox->createGeoCodingApi($query, array('type'=>'address','limit'=>1));
$json = json_encode($geoCodingApi->getJson());

?>

<script src='https://api.mapbox.com/mapbox-gl-js/v0.40.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v0.40.1/mapbox-gl.css' rel='stylesheet' />
<div class="map mapbox" id="mapBox" style="width: 600px; height: 600px;"></div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoicG13Y29tbXVuaWNhdGlvbnMiLCJhIjoiY2o4NXJudDdtMGkzejJ3bXA0YTgzaXJtbiJ9.TXHNSEROw-Wm-BhMlOPyRQ';
    var map = new mapboxgl.Map({
        container: 'mapBox',
        style: 'mapbox://styles/pmwcommunications/cj85srmw51zrp2rnqbpwrtyxy',
        center: [-100.486052, 37.830348],
        zoom: 0,
        scrollZoom: false,
    });
    map.addControl(new mapboxgl.NavigationControl());
    map.on('load', function() {
        map.loadImage('/examples/PointOnMap/img/pin.png', function(error, image) {
            if (error) throw error;
            map.addImage('pin', image);
            map.addLayer({
                "id": "points",
                "type": "symbol",
                "source": {
                    "type": "geojson",
                    "data": <?php echo $json ?>
                },
                "layout": {
                    "icon-image": "pin",
                    "icon-size": 1
                }
            });
        });
    });
    </script>
