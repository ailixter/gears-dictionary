<?php

namespace Ailixter\Gears\Dictionary;

use Ailixter\Gears\Dictionary\Exceptions\AccessException;
use Ailixter\Gears\Dictionary\Exceptions\RequiredKeyException;
use Ailixter\Gears\Dictionary\Helpers\CallableValues;
use ArrayAccess;
use Countable;

/*
 * (C) 2016, AII (Alexey Ilyin).
 */

class ReadonlyStruct implements ReadonlyDictionaryInterface, ArrayAccess, Countable
{
    use CallableValues;
    
    protected $data;
    private $pathSeparator = '/';

    /**
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function setPathSeparator($pathSeparator)
    {
        $this->pathSeparator = $pathSeparator;
        return $this;
    }

    public function all()
    {
        return $this->data;
    }
    
    /**
     * Get value at $path, $default otherwise.
     * @param string $path
     * @param mixed  $default
     * @return mixed
     */
    public function get($path, $default = null)
    {
        $data = $this->data;
        foreach ($this->castPath($path) as $key) {
            if (!strlen($key = trim($key))) {
                continue;
            }
            if (is_scalar($data) || !isset($data[$key])) {
                return $this->getDefault($key, $default);
            }
            $data = $data[$key];
        }
        return $data;
    }

    /**
     * Check if the value at $path exists.
     * @param  string $path
     * @return boolean
     */
    public function has($path)
    {
        $data = $this->data;
        foreach ($this->castPath($path) as $key) {
            if (!strlen($key = trim($key))) {
                continue;
            }
            if (is_scalar($data) || !isset($data[$key])) {
                return false;
            }
            $data = $data[$key];
        }
        return true;
    }

    public function required($path)
    {
        $data = $this->data;
        foreach ($this->castPath($path) as $key) {
            if (!strlen($key = trim($key))) {
                continue;
            }
            if (is_scalar($data) || !isset($data[$key])) {
                throw RequiredKeyException::forGet($key, $data);
            }
            $data = $data[$key];
        }
        return $data;
    }

    protected function castPath($path)
    {
        return is_array($path) ? $path : explode($this->pathSeparator, $path);
    }

    //---=====[ Interface implementation ]=====---//

    public function count()
    {
        return count($this->data);
    }

    public function offsetSet($path, $value)
    {
        throw AccessException::forSet($path, $this, $value);
    }

    public function offsetExists($path)
    {
        return $this->has($path);
    }

    public function offsetUnset($path)
    {
        throw AccessException::forSet($path, $this, null);
    }

    public function offsetGet($path)
    {
        return $this->get($path);
    }
}
