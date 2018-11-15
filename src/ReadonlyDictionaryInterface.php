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
    public function get($key, $default = null);

    public function has($key);

    public function all();
}
