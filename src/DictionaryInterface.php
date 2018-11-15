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
    public function remove($key);

    public function set($key, $value);
}
