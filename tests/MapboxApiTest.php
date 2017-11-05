<?php

namespace ZakClayton\Mapbox\Test;

use ZakClayton\Mapbox\MapboxApi;
use ZakClayton\Mapbox\Exceptions\MapboxException;

class MapboxApiTest extends \PHPUnit\Framework\TestCase
{

    public function testMapboxApiExceptionThrownWhenNoTokenSet()
    {
        $this->expectException(MapboxException::class);
        $mapbox = new MapboxApi();
    }

    public function testMapboxApiExceptionThrownWhenTokenNotString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $mapbox = new MapboxApi(1230912830918239);
    }

    

}
