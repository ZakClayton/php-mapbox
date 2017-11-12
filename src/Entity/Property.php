<?php

    namespace ZakClayton\Mapbox\Entity;

    use ZakClayton\Mapbox\Abstracts\Entity;

    /**
     * Class Geometry
     * @package ZakClayton\Mapbox\Entity
     */
    class Property extends Entity {

        /**
         * Property constructor.
         * @param $data
         */
        public function __construct($data)
        {
            parent::__construct($data);
        }

        /**
         * A string of the full street address for the returned @poi feature.
         * Note that unlike the @address property for  address features, this property is inside the @properties object.
         * @return string|null
         */
        public function getAddress() {
            return !empty($this->data->address) ? $this->data->address : null;
        }

        /**
         * A string of comma-separated categories for the returned  poi feature.
         * @return string|null
         */
        public function getCategory() {
            return !empty($this->data->category) ? $this->data->category : null;
        }

        /**
         * A formatted string of the telephone number for the returned @poi feature.
         * @return string|null
         */
        public function getTel() {
            return !empty($this->data->tel) ? $this->data->tel : null;
        }

        /**
         * The name of a suggested Maki icon to visualize a @poi feature based on its category .
         * @return string|null
         */
        public function getMaki() {
            return !empty($this->data->maki) ? $this->data->maki : null;
        }

        /**
         * A boolean value indicating whether a  poi feature is a landmark.
         * Landmarks are particularly notable or long-lived features like schools, parks, museums and places of worship.
         * @return string|null
         */
        public function getLandmark() {
            return !empty($this->data->landmark) ? $this->data->landmark : null;
        }

        /**
         * The Wikidata identifier for the returned feature.
         * @return string|null
         */
        public function getWikiData() {
            return !empty($this->data->wikidata) ? $this->data->wikidata : null;
        }

        /**
         * The ISO 3166-1 country and ISO 3166-2 region code for the returned feature.
         * @return string|null
         */
        public function getShortCode() {
            return !empty($this->data->short_code) ? $this->data->short_code : null;
        }

    }