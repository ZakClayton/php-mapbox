<?php

namespace ZakClayton\Mapbox\Api;

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
    protected $mode;

    /** @var string GeoCoding Query String */
    protected $query;

    /** @var MapboxApi The Parent Class */
    protected $mapboxApi;

    /** @var string Format for the API response */
    protected $format = 'json';

    /**
     * Constructor
     */
    public function __construct($mode = null, $query = null) {

        if (empty($mode)) {
            throw new MapboxException('Parameter $mode is Required, GeoCoding($mode, $query)');
        }

        if (empty($mode)) {
            throw new MapboxException('Parameter $query is Required, GeoCoding($mode, $query)');
        }

        $this->mode  = $mode;
        $this->query = $query;

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

        return $url;

    }

    /**
     * Make API call, retrieve JSON response with data or error.
     *
     * @todo Create EntityFactory 
     * @return json API Response
     */
    public function call() {
        try {
            $ei = parent::call();
            return $ei;
        } catch ( MapboxException $e ) {

        }
    }

}
