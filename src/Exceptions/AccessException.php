<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */
namespace Ailixter\Gears\Dictionary\Exceptions;

use Ailixter\Gears\Exceptions\Exception;

/**
 * @author AII (Alexey Ilyin)
 */
class AccessException extends Exception
{
    public static function forSet($key, $data, $value)
    {
        return new static(sprintf("'%s' cannot be set to %s in %s", 
            $key, static::getTypename($value), static::getTypename($data)
        ));
    }

}
