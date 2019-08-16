<?php

/*
 * (C) 2017, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Dictionary;

/**
 * @author AII (Alexey Ilyin)
 */
class Struct extends ReadonlyStruct implements DictionaryExtraInterface
{
    /**
     * If exists $pool[$data([key])+], copy it to $data([key])+ recursively.
     * @param array $data
     * @param mixed $pool false | array
     */
    public static function build(array &$data, $pool = false)
    {
        $pool or $pool = $data;
        foreach ($data as &$val) {
            if (!is_scalar($val)) {
                settype($val, 'array')
                    and self::build($val, $pool);
            } elseif (isset($val[0]) && $val[0] === '@' && isset($pool[substr($val, 1)])) {
                is_scalar($val = $pool[$val])
                    or settype($val, 'array');
            }
        }
    }

    public function refer(array &$data)
    {
        $this->data = &$data;
        return $this;
    }

    public function extract($path, $default = null)
    {
        $key = null;
        $paths = $this->castPath($path);
        $left = count($paths);
        $data = &$this->data;
        foreach ($paths as $key) {
            if (!strlen($key = trim($key))) {
                continue;
            }
            if (is_scalar($data) || !isset($data[$key])) {
                break;
            }
            if (--$left > 0) {
                $data = $data[$key];
            } else {
                $result = $data[$key];
                unset($data[$key]);
                return $result;
            }
        }
        return static::getDefault($data, $key, $default);
    }

    public function &ref($path)
    {
        $data = &$this->data;
        foreach ($this->castPath($path) as $name) {
            if (!strlen($name = trim($name))) {
                continue;
            }
            if (is_scalar($data)) {
                $data = [];
            }
            $data = &$data[$name];
        }
        return $data;
    }

    public function set($path, $value)
    {
        $data = &$this->ref($path);
        $data = $value;
        return $this;
    }

    public function setref($path, &$value)
    {
        $data = &$this->data;
        foreach ($this->castPath($path) as $name) {
            if (!strlen($name = trim($name))) {
                continue;
            }
            if (is_scalar($data)) {
                $data = array();
            }
            $tnam = $name;
            $tdat = &$data;
            $data = &$data[$name];
        }
        $tdat[$tnam] = &$value;
        return $this;
    }

    public function add($path, $value)
    {
        $data = &$this->ref($path);
        settype($data, 'array');
        $data[] = $value;
        return $this;
    }

    public function addref($path, &$value)
    {
        $data = &$this->ref($path);
        settype($data, 'array');
        $data[] = &$value;
        return $this;
    }

    public function remove($path)
    {
        $data = &$this->data;
        foreach ($this->castPath($path) as $name) {
            if (!strlen($name = trim($name))) {
                continue;
            }
            if (is_scalar($data)) {
                $data = array();
            }
            $tnam = $name;
            $tdat = &$data;
            $data = &$data[$name];
        }
        unset($tdat[$tnam]);
        return $this;
    }

    public function offsetSet($path, $value)
    {
        $this->set($path, $value);
    }

    public function offsetUnset($path)
    {
        $this->remove($path);
    }

}
