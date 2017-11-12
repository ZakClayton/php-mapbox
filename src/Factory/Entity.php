<?php

    namespace ZakClayton\Mapbox\Factory;

    use Psr\Http\Message\ResponseInterface as Response;
    use ZakClayton\Mapbox\Entity\EntityIterator;
    use ZakClayton\Mapbox\Exceptions\MapboxException;
    use ZakClayton\Mapbox\Interfaces\EntityFactory;

    class Entity implements EntityFactory {

        /**
         * @var array
         */
        protected $apiEntities = array(
            'Feature' => '\ZakClayton\Mapbox\Entity\Feature',
        );

        /**
         * Returns the entity iterator containing appropriate entities built by the contents of the response.
         *
         * @param Response $response
         * @return mixed
         */
        public function createAppropriateEntityIterator(Response $response)
        {

            $this->checkResponseFormat($response);

            $arr = \GuzzleHttp\json_decode($response->getBody());

            $objects = array();
            if (!empty($arr->features)) {
                foreach ($arr->features as $object) {
                    if (isset($this->apiEntities[$object->type])) {
                        $class = $this->apiEntities[$object->type];
                        $objects[] = new $class($object);
                    }
                }
                return new EntityIterator($objects, $response);
            } else {
                // ToDo: Manage other responses from the API
            }

        }

        /**
         * @param Response $response
         * @throws MapboxException
         */
        protected function checkResponseFormat(Response $response) {

            $arr = \GuzzleHttp\json_decode($response->getBody());

            if (empty($arr)) {
                throw new MapboxException('Mapbox Returned an Error.');
            }

            $required = array(
                'features' => 'Features property missing - cannot extract features if they are not present',
                'query'    => 'No query was sent to Mapbox',
            );

            foreach ($required as $k => $v) {
                if (!isset($arr->$k)) {
                    throw new MapboxException($v);
                }
            }

        }
    }