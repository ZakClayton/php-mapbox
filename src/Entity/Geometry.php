<?php

    namespace ZakClayton\Mapbox\Entity;

    use ZakClayton\Mapbox\Abstracts\Entity;

    /**
     * Class Geometry
     * @package ZakClayton\Mapbox\Entity
     */
    class Geometry extends Entity {

        /**
         * Geometry constructor.
         * @param object $data
         */
        public function __construct($data)
        {
            parent::__construct($data);
        }

        /**
         * "Point", a GeoJSON type from the GeoJSON specification .
         * @return string
         */
        public function getType() {
            return $this->data->type;
        }

        /**
         * An array in the format [ longitude,latitude ] at the center of the specified bbox
         * @return array
         */
        public function getCoordinates() {
            return $this->data->coordinates;
        }

        /**
         * A boolean value indicating if an  address is interpolated along a road network.
         * This field is only present when the feature is interpolated.
         * @return string|null
         */
        public function getInterpolated() {
            return !empty($this->data->interpolated) ? $this->data->interpolated : null;
        }

    }