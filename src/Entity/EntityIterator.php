<?php

    namespace ZakClayton\Mapbox\Entity;

    use Psr\Http\Message\ResponseInterface as Response;
    use ZakClayton\Mapbox\Abstracts\Entity;

    class EntityIterator implements \Countable, \Iterator, \ArrayAccess {

        /**
         * @var array
         */
        protected $data;

        /**
         * @var int
         */
        protected $cursor = -1;

        /**
         * @var Entity
         */
        protected $current;

        /**
         * @var Response
         */
        protected $response;

        /**
         * EntityIterator constructor.
         * @param array $objects
         * @param Response $response
         */
        public function __construct(array $objects, Response $response)
        {
            $this->response = $response;
            $this->data = $objects;
            $this->next();
        }

        /**
         * Returns the original response.
         *
         * @return mixed
         */
        public function getResponse()
        {
            return $this->response;
        }

        /**
         * Return the current element
         * @link http://php.net/manual/en/iterator.current.php
         * @return mixed Can return any type.
         * @since 5.0.0
         */
        public function current()
        {
            while (!$this->offsetExists($this->cursor)) {
                $this->next();
            }
            return $this->data[$this->cursor];
        }

        /**
         * Move forward to next element
         * @link http://php.net/manual/en/iterator.next.php
         * @return void Any returned value is ignored.
         * @since 5.0.0
         */
        public function next()
        {
            $this->cursor++;
        }

        /**
         * Return the key of the current element
         * @link http://php.net/manual/en/iterator.key.php
         * @return mixed scalar on success, or null on failure.
         * @since 5.0.0
         */
        public function key()
        {
            return $this->cursor;
        }

        /**
         * Checks if current position is valid
         * @link http://php.net/manual/en/iterator.valid.php
         * @return boolean The return value will be casted to boolean and then evaluated.
         * Returns true on success or false on failure.
         * @since 5.0.0
         */
        public function valid()
        {
            if (count($this->data)) {
                return ($this->cursor <= max(array_keys($this->data)));
            } else {
                return false;
            }
        }

        /**
         * Rewind the Iterator to the first element
         * @link http://php.net/manual/en/iterator.rewind.php
         * @return void Any returned value is ignored.
         * @since 5.0.0
         */
        public function rewind()
        {
            if ($this->cursor > 0) {
                $this->cursor = -1;
                $this->next();
            }
        }

        /**
         * @return mixed
         */
        protected function _getZerothEntity()
        {
            return ($this->cursor == -1) ? $this->data[0] : $this->current();
        }

        /**
         * @param $name
         * @param $args
         * @return mixed
         */
        public function __call($name, $args)
        {
            $isGetter = substr($name, 0, 3) == 'get';
            if ($isGetter) {
                $zeroth = $this->_getZerothEntity();
                if (method_exists($this->_getZerothEntity(), $name)) {
                    $rv = $zeroth->$name(...$args);
                } else {
                    $property = lcfirst(substr($name, 3, strlen($name) - 3));
                    $rv = $zeroth->$property;
                }
                return $rv;
            }
            throw new \BadMethodCallException('No such method: ' . $name);
        }

        /**
         * @param $name
         * @return mixed
         */
        public function __get($name)
        {
            $entity = $this->_getZerothEntity();
            return $entity->$name;
        }

        /**
         * Whether a offset exists
         * @link http://php.net/manual/en/arrayaccess.offsetexists.php
         * @param mixed $offset <p>
         * An offset to check for.
         * </p>
         * @return boolean true on success or false on failure.
         * </p>
         * <p>
         * The return value will be casted to boolean if non-boolean was returned.
         * @since 5.0.0
         */
        public function offsetExists($offset)
        {
            return (isset($this->data[$offset]));
        }

        /**
         * Offset to retrieve
         * @link http://php.net/manual/en/arrayaccess.offsetget.php
         * @param mixed $offset <p>
         * The offset to retrieve.
         * </p>
         * @return mixed Can return all value types.
         * @since 5.0.0
         */
        public function offsetGet($offset)
        {
            if ($this->offsetExists($offset)) {
                return $this->data[$offset];
            }
            throw new \OutOfBoundsException("Offset '$offset' not present");
        }

        /**
         * Offset to set
         * @link http://php.net/manual/en/arrayaccess.offsetset.php
         * @param mixed $offset <p>
         * The offset to assign the value to.
         * </p>
         * @param mixed $value <p>
         * The value to set.
         * </p>
         * @return void
         * @since 5.0.0
         */
        public function offsetSet($offset, $value)
        {
            throw new \BadMethodCallException(
                'Resultset is read only'
            );
        }

        /**
         * Offset to unset
         * @link http://php.net/manual/en/arrayaccess.offsetunset.php
         * @param mixed $offset <p>
         * The offset to unset.
         * </p>
         * @return void
         * @since 5.0.0
         */
        public function offsetUnset($offset)
        {
            unset($this->data[$offset]);
        }

        /**
         * Count elements of an object
         * @link http://php.net/manual/en/countable.count.php
         * @return int The custom count as an integer.
         * </p>
         * <p>
         * The return value is cast to an integer.
         * @since 5.1.0
         */
        public function count()
        {
            return count($this->data);
        }

    }

