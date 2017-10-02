<?php

namespace ZakClayton\Mapbox\Traits;

use ZakClayton\Mapbox\MapboxApi;

/**
 * Class MapboxAware
 * @property MapboxApi
 * @package ZakClayton\Mapbox\Traits
 */
trait MapboxApiAware {

    /**
     * Sets a Mapbox Instance on the child class
     * Used to later fetch the token, HTTP Client, Entity Factory
     * @param MapboxApi $m
     * @return $this
     */
    public function registerMapboxApi(MapboxApi $m)
    {
        $this->mapboxApi = $m;

        return $this;
    }

}
