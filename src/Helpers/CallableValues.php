<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Dictionary\Helpers;

/**
 * @author AII (Alexey Ilyin)
 */
trait CallableValues
{
    protected function getDefault($key, $default)
    {
        return !is_callable($default) ? $default :
            call_user_func($default, $key, $this);
    }
}
