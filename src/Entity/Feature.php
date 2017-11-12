<?php

    namespace ZakClayton\Mapbox\Entity;

    use ZakClayton\Mapbox\Abstracts\Entity;
    use ZakClayton\Mapbox\Entity\Geometry;

    class Feature extends Entity {

        protected $geometry = null;

        protected $property = null;

        /**
         * Feature constructor.
         * @param object $data
         */
        public function __construct($data)
        {
            parent::__construct($data);

            if (!empty($data->geometry)) {
                $this->geometry = new Geometry($data->geometry);
            }

            if (!empty($data->properties)) {
                $this->property = new Property($data->properties);
            }
        }

        /**
         * Returns ID of the feature object
         * @return mixed
         */
        public function getId() {
            return $this->data->id;
        }

        /**
         * Should always return Feature
         * @return mixed
         */
        public function getType() {
            return $this->data->type;
        }

        /**
         * Returns the feature place type (place, address, poi)
         * @return array
         */
        public function getPlaceType() {
            return $this->data->place_type;
        }

        /**
         * Returns how good a match the query was to this feature.
         * @return int
         */
        public function getRelevance() {
            return $this->data->relevance;
        }

        /**
         * A string of the house number for the returned  address feature.
         * Note that unlike the @address property for poi features, this property is outside the @properties object.
         * @return string|null
         */
        public function getAddress() {
            return !empty($this->data->address) ? $this->data->address : null;
        }

        /**
         * An object describing the feature.
         * The property object is unstable and only Carmen GeoJSON properties are guaranteed.
         * @return Property
         */
        public function getProperties() {
            return $this->property;
        }

        /**
         * Returns string query match
         * @return string
         */
        public function getText() {
            return $this->data->text;
        }

        /**
         * Returns a string of the returned feature place name
         * @return string
         */
        public function getPlaceName() {
            return $this->data->place_name;
        }

        /**
         * An array bounding box in the form [ minX,minY,maxX,maxY ].
         * @return array
         */
        public function getBBox() {
            return $this->data->bbox;
        }

        /**
         * 	An array in the form [ longitude,latitude ] at the center of the specified @bbox.
         * @return array
         */
        public function getCenter() {
            return $this->data->center;
        }

        /**
         * An object describing the spatial geometry of the returned feature.
         * @return Geometry
         */
        public function getGeometry() {
            return $this->geometry;
        }


        /**
         * An array representing the hierarchy of encompassing parent features.
         * Each parent feature may include any of the above properties.
         * @return array
         */
        public function getContext() {
            return $this->data->context;
        }


    }