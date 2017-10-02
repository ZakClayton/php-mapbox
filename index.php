<?php

require_once "vendor/autoload.php";

use SSD\DotEnv\DotEnv;
use ZakClayton\Mapbox\MapboxApi;
use ZakClayton\Mapbox\Exception\MapboxException;

try {

    $dotenv = new DotEnv([
        __DIR__ . '/.env'
    ]);
    $dotenv->load();
    $dotenv->required([
        'MAPBOX_ACCESS_TOKEN'
    ]);

    $mapbox = new MapboxApi(getenv('MAPBOX_ACCESS_TOKEN'));

    $geoCodingApi = $mapbox->createGeoCodingApi('mapbox.places','Lingfield');

    var_dump(json_decode($geoCodingApi->call()->getBody()));

} catch (MapboxException $e) {

    var_dump($e);

}
