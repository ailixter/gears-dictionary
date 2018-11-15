<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */
namespace Ailixter\Gears\Dictionary\Exceptions;

use Ailixter\Gears\Exceptions\Exception;

/**
 * @author AII (Alexey Ilyin)
 */
class RequiredKeyException extends Exception
{
    public static function forGet($path, $data)
    {
        $path = join('/', (array)$path);
        return new static("'$path' is required in ".static::getTypename($data));
    }
}
