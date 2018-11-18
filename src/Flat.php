<?php

/*
 * (C) 2017, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Dictionary;


/**
 * @author AII (Alexey Ilyin)
 */
class Flat extends ReadonlyFlat implements DictionaryExtraInterface
{
    public function refer(array &$data)
    {
        $this->data = &$data;
        return $this;
    }

    /**
     * Get and unset $array[$key] if it's set, return $default otherwise.
     * @param array $array
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function extract($key, $default = null)
    {
        if (!$this->has($key)) {
            return $this->getDefault($key, $default);
        }
        $result = $this->get($key);
        $this->remove($key);
        return $result;
    }

    public function &ref($key)
    {
        return $this->data[$key];
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function setref($key, &$value)
    {
        $this->data[$key] = &$value;
        return $this;
    }

    public function remove($key)
    {
        unset($this->data[$key]);
        return $this;
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->remove($key);
    }

}
