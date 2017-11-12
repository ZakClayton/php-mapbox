<?php

    namespace ZakClayton\Mapbox\Abstracts;


    /**
     * Class Entity
     *
     * @package \ZakClayton\Mapbox\Abstracts
     */
    abstract class Entity {

        /**
         * @var array
         */
        protected $data;

        /**
         * Entity constructor.
         * @param object $data
         */
        public function __construct($data)
        {
            $this->data = $data;
        }

        /**
         * @return array
         */
        public function getData()
        {
            return $this->data;
        }

        /**
         * @param $name
         * @return mixed|null $data
         */
        public function __get($name)
        {
            return (isset($this->data->$name)) ? $this->data->$name : null;
        }

        /**
         * @param $name
         * @param $arguments
         * @return mixed|null
         */
        public function __call($name, $arguments)
        {
            $isGetter = substr($name, 0, 3) == 'get';
            if ($isGetter) {
                $property = lcfirst(substr($name, 3, strlen($name) - 3));
                return $this->$property;
            }
            throw new \BadMethodCallException('No such method: '.$name);
        }

    }