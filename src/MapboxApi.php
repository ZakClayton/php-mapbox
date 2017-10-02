<?php

namespace ZakClayton\Mapbox;

use ZakClayton\Mapbox\Api\GeoCoding;
use GuzzleHttp\Client;

/**
 *
 *
 * @class MapboxApi
 */
class MapboxApi
{

    /** @var string The API access token */
    private static $_token = null;

    /** @var string Instance Token, settable once per new instance */
    private $_instanceToken;

    /** @var GuzzleHttp $client */
    protected $client;

    /**
     * Create a new Skeleton Instance
     */
    public function __construct($_token = null) {
        if ($_token === null) {
            if (self::$_token === null) {
                $msg = 'No token provided, and none is globally set.';
                $msg .= 'User Mapbox::setToken, or instantiate the Mapbox class with a $_token parameter.';
                throw new MapboxException($msg);
            }
        } else {
            self::validateToken($_token);
            $this->_instanceToken = $_token;
        }
    }

    /**
     * Sets the token for all future new instances
     * @param $token string The API Access token
     * @return void
     */
    public static function setToken($token) {
        self::validateToken($token);
        self::$_token = $token;
    }

    /**
     * Checks that the token is valid
     *
     * @param $token string The API Token
     * @return boolval
     */
    private static function validateToken($token) {
        if (!is_string($token)) {
            throw new \InvalidArgumentException('Token is not a string.');
        }
        return true;
    }

    /**
     * Return the defined token
     *
     * @return string The API Token
     */
    public function getToken() {
        return ($this->_instanceToken) ? $this->_instanceToken : self::$_token;
    }

    /**
     * Set the HTTP Client used for the API calls
     *
     * @return $this
     */
    public function setHttpClient(Client $client = null) {
        if ($client === null) {
            $client = new Client();
        }
        $this->client = $client;
        return $this;
    }

    /**
     * Get the HTTP Client used for API calls
     *
     * @return $client
     */
    public function getHttpClient() {
        return $this->client;
    }

    /**
     * Create GeoCoding Api Call
     *
     * @param string Mode - Set the mode for the API
     * @param string Query - The Query String for the API
     */
    public function createGeoCodingApi($mode = null, $query = null) {
        $api = new GeoCoding($mode, $query);

        if (!$this->getHttpClient()) {
            $this->setHttpClient();
        }

        return $api->registerMapboxApi($this);
    }

}
