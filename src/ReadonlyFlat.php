<?php

/*
 * (C) 2017, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Dictionary;

use Ailixter\Gears\Dictionary\Exceptions\AccessException;
use Ailixter\Gears\Dictionary\Exceptions\RequiredKeyException;
use Ailixter\Gears\Dictionary\Helpers\CallableValues;
use ArrayAccess;
use Countable;

/**
 * @author AII (Alexey Ilyin)
 */
class ReadonlyFlat implements ReadonlyDictionaryInterface, ArrayAccess, Countable
{
    use CallableValues;

    /**
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Get $array[$key] if it's set, $default otherwise.
     * @param  array $data
     * @param  mixed $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] :
            $this->getDefault($key, $default);
    }

    /**
     * 
     * @param array $data
     * @param mixed $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->data[$key]);//???
    }

    /**
     * Get $array[$key] if it's set, or failed assertion otherwise.
     * @param array $data
     * @param mixed $key
     * @return mixed
     */
    public function required($key)
    {
        if (!$this->has($key)) {
            throw RequiredKeyException::forGet($key, $this);
        }
        return $this->get($key);
    }

    public function all()
    {
        return $this->data;
    }

    public function count()
    {
        return count($this->data);
    }

    public function offsetSet($key, $value)
    {
        throw AccessException::forSet($key, $this, $value);
    }

    public function offsetUnset($key)
    {
        throw AccessException::forSet($key, $this, null);
    }

    public function offsetExists($key)
    {
        return $this->has($key);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }
}
