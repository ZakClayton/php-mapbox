<?php

namespace ZakClayton\Mapbox;

use GuzzleHttp\Client;
use ZakClayton\Mapbox\Exceptions\MapboxException;
use ZakClayton\Mapbox\Factory\Entity;
use ZakClayton\Mapbox\Interfaces\EntityFactory;
use ZakClayton\Mapbox\Api\GeoCoding;

/**
 *
 *
 * @class MapboxApi
 * @package ZakClayton\Mapbox
 */
class MapboxApi
{

    /** @var string The API access token */
    private static $_token = null;

    /** @var string Instance Token, settable once per new instance */
    private $_instanceToken;

    /** @var GuzzleHttp $client */
    protected $client;

    /** @var  EntityFactory The Factory which created Entities from Responses */
    protected $factory;

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
     * Sets the Entity Factory which will create the Entities from Responses
     * @param EntityFactory $factory
     * @return $this
     */
    public function setEntityFactory(EntityFactory $factory = null)
    {
        if ($factory === null) {
            $factory = new Entity();
        }
        $this->factory = $factory;
        return $this;
    }
    /**
     * Returns the Factory responsible for creating Entities from Responses
     * @return EntityFactory
     */
    public function getEntityFactory()
    {
        return $this->factory;
    }

    /**
     * Create GeoCoding Api Call
     *
     * @param string Query - The Query String for the API
     * @param array Params - Any additional Options set for the API
     * @return $this
     */
    public function createGeoCodingApi($query = null, $params = array()) {
        $api = new GeoCoding($query, $params);
        if (!$this->getHttpClient()) {
            $this->setHttpClient();
        }
        if (!$this->getEntityFactory()) {
            $this->setEntityFactory();
        }
        return $api->registerMapboxApi($this);
    }

}
