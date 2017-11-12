<?php

namespace ZakClayton\Mapbox\Api;

use ZakClayton\Mapbox\Exceptions\MapboxException;
use ZakClayton\Mapbox\MapboxApi;
use ZakClayton\Mapbox\Abstracts\Api;
use ZakClayton\Mapbox\Traits\MapboxApiAware;

/**
 * Class GeoCoding
 * @package ZakClayton/Mapbox/Api
 */
class GeoCoding extends Api {

    use MapboxApiAware;

    /** @var string The API URL */
    protected $url = 'https://api.mapbox.com';

    /** @var string The API that you want to use */
    protected $apiUrl = 'geocoding';

    /** @var string Select API Version */
    protected $version = 'v5';

    /** @var string Select GeoCoding Mode */
    protected $mode = 'mapbox.places';

    /** @var string GeoCoding Query String */
    protected $query;

    /** @var array GeoCoding Parameters Array */
    protected $params;

    /** @var MapboxApi The Parent Class */
    protected $mapboxApi;

    /** @var string Format for the API response */
    protected $format = 'json';

    /**
     * Constructor
     */
    public function __construct($query = null, $params = array()) {
        if (empty($query)) {
            throw new MapboxException('Parameter $query is Required, GeoCoding($mode, $query)');
        }
        $this->query = $query;
        $this->params = $params;
    }

    /**
     * Build GeoCoding Url String
     *
     *
     * @return $url
     */
    public function buildUrl() {

        $url = rtrim($this->url, '/');

        if (!empty($this->apiUrl)) {
            $url .= '/' . trim($this->apiUrl,'/') ;
        } else {
            throw new MapboxException('API Url is a required parameter');
        }

        if (!empty($this->version)) {
            $url .= '/' . trim($this->version,'/') ;
        } else {
            throw new MapboxException('API Version is a required parameter');
        }

        $url .= '/' . trim($this->mode, '/') ;
        $url .= '/' . trim($this->query, '/') . '.' . $this->format;
        $url .= '?access_token=' . $this->mapboxApi->getToken();

        if(!empty($this->params)) {
            $url .= $this->makeParametersQueryString($this->params);
        }

        return $url;

    }

    /**
     * Convert parameter array into query string
     *
     */
    public function makeParametersQueryString($params = array()) {
        if(!empty($params)) {
            $queryStr = '';
            foreach ($params as $key => $value) {
                $queryStr .= "&{$key}={$value}";
            }
            return $queryStr;
        }
        return ;
    }

    /**
     * Make API call, retrieve JSON response with data or error.
     *
     * @todo Create EntityFactory
     */
    public function call() {
        try {
            $ei = parent::call();
            return $ei;
        } catch ( MapboxException $e ) {
            print "Something went wrong: " . $e;
        }
    }

    /**
     * Make API call and return JSON
     *
     * @return json API Response
     */
    public function getJson() {
        $response = $this->call()->getResponse();
        if($response) return $response;
        return '{}';
    }

}
