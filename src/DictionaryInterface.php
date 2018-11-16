<?php

/*
 * (C) 2017, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Dictionary;

/**
 *
 * @author AII (Alexey Ilyin)
 */
interface DictionaryInterface extends ReadonlyDictionaryInterface
{
    /**
     * @param string|int $key
     * @return self
     */
    public function remove($key);
    /**
     * @param string|int $key
     * @param mixed $value
     * @return self
     */
    public function set($key, $value);
}
