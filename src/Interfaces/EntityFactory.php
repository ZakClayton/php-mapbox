<?php

    namespace ZakClayton\Mapbox\Interfaces;

    use Psr\Http\Message\ResponseInterface as Response;
    use ZakClayton\Mapbox\Entity\EntityIterator;

    interface EntityFactory {

        /**
         * Returns the entity iterator containing appropriate entities built by the contents of the response.
         *
         * @param Response $response
         * @return mixed
         */
        public function createAppropriateEntityIterator(Response $response);

    }