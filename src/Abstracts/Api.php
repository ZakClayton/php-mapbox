<?php

namespace ZakClayton\Mapbox\Abstracts;

use ZakClayton\Mapbox\MapboxApi;
use ZakClayton\Mapbox\Traits\MapboxApiAware;

/**
 * Class Api
 *
 * @package \ZakClayton\Mapbox\Abstracts
 */
abstract class Api implements \ZakClayton\Mapbox\Interfaces\Api {

    /** @var int Timeout value in ms - defaults to 30s if empty */
    private $timeout = 30000;

    /** @var string HTTP Method */
    protected $method = 'GET';

    /** @var string The API URL */
    protected $url;

    /** @var string The API that you want to use */
    protected $apiUrl;

    /** @var string Select API Version */
    protected $version;

    /** @var MapboxApi - the parent class */
    protected $mapboxApi;

    use MapboxApiAware;

    public function __construct($url) {
        $url = trim((string)$url);
        if (strlen($url) < 4) {
            throw new \InvalidArgumentException(
                'URL must be a string of at least four characters in length'
            );
        }
    }

    /**
     * Setting the timeout will define how long Mapbox will keep trying
     * to fetch the API results.
     *
     * @param int|null $timeout Defaults to 30000 even if not set
     *
     * @return $this
     */
    public function setTimeout($timeout = null) {
        if ($timeout === null) {
            $timeout = 30000;
        }
        if (!is_int($timeout)) {
            throw new \InvalidArgumentException('Parameter is not an integer');
        }
        if ($timeout < 0) {
            throw new \InvalidArgumentException(
                'Parameter is negative. Only positive timeouts accepted.'
            );
        }
        $this->timeout = $timeout;
        return $this;
    }


    /**
     * Setting the HTTP Method will change how the API requests endpoints
     *
     * @param string|null
     *
     * @return $this
     */
    public function setMethod($method = null) {

        if ($method == null) {
            $method = 'GET';
        }
        $this->method = $method;
        return $this;
    }


    /**
     * Build the API Url
     *
     *
     *
     * @return $url
     */
    public function buildUrl() {

        $url = rtrim($this->url, '/');

        if (!empty($this->apiUrl)) {
            $url .= '/' . trim($this->apiUrl,'/') ;
        } else {
            throw new \InvalidArgumentException('API Url is a required parameter');
        }

        if (!empty($this->version)) {
            $url .= '/' . trim($this->version,'/') ;
        } else {
            throw new \InvalidArgumentException('API Version is a required parameter');
        }

        return $url;
    }

    /**
     * Call the API using the HTTP Response
     *
     * @todo EntityFactory to convert the response into Entities
     * @return json $response
     */
    public function call() {
        return $this->mapboxApi->getHttpClient()->request($this->method, $this->buildUrl());
    }
}
