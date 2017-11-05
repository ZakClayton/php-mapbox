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
    $geoCodingApi = $mapbox->createGeoCodingApi('Lingfield, RH7 6NG', array('type'=>'address','country'=>'GB'));
    var_dump($geoCodingApi->getJson());

} catch (MapboxException $e) {

    var_dump($e);

}
