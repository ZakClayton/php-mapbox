<?php

namespace ZakClayton\Mapbox\Interfaces;

interface Api {

    /**
     * @param int|null $timeout
     * @return $this
     */
    public function setTimeout($timeout = null);

    /**
     * @param string|null $method
     * @return $this
     */
    public function setMethod($method = null);

    /**
     *
     * @return $url
     */
    public function buildUrl();

}
