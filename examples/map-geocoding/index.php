<?php

    require_once "../../vendor/autoload.php";

    use SSD\DotEnv\DotEnv;
    use ZakClayton\Mapbox\MapboxApi;
    use ZakClayton\Mapbox\Exceptions\MapboxException;

    $dotenv = new DotEnv([
        __DIR__ . '/.env'
    ]);
    $dotenv->load();
    $dotenv->required([
        'MAPBOX_ACCESS_TOKEN'
    ]);

    try {
        $query        = 'The Statue of Liberty';
        $mapbox       = new MapboxApi(getenv('MAPBOX_ACCESS_TOKEN'));
        $geoCodingApi = $mapbox->createGeoCodingApi($query, array('type'=>'address','limit'=>1));
        $json         = $geoCodingApi->getJson();
        $entity       = $geoCodingApi->call();

        echo '<pre>';
        var_dump($json);
        echo '</pre>';

        echo '<pre>';
        var_dump($entity);
        echo '</pre>';

    } catch (MapboxException $e) {
        print $e;
    }