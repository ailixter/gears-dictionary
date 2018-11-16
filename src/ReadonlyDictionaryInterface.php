<?php

/*
 * (C) 2017, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Dictionary;

/**
 *
 * @author AII (Alexey Ilyin)
 */
interface ReadonlyDictionaryInterface
{
    /**
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);
    /**
     * @param string|int $key
     * @return mixed
     */
    public function required($key);
    /**
     * @param string|int $key
     * @return bool
     */
    public function has($key);
    /**
     * @return array|arrayAccess
     */
    public function all();
}
