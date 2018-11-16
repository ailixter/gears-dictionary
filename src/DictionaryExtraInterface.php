<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */
namespace Ailixter\Gears\Dictionary;

/**
 *
 * @author AII (Alexey Ilyin)
 */
interface DictionaryExtraInterface extends DictionaryInterface
{
    /**
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function extract($key, $default = null);
    /**
     * @param string|int $key
     * @return mixed
     */
    public function &ref($key);
    /**
     * @param string|int $key
     * @param mixed $value
     * @return self
     */
    public function setref($key, &$value);
    /**
     * @param array $data
     * @return self
     */
    public function refer(array &$data);
}
