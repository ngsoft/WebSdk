<?php

namespace Adminer;

class Config
{

    private static $config = [];

    /**
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed
     */
    public static function getItem($name, $defaultValue = null)
    {
        return var_get($name, self::$config, $defaultValue);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public static function setItem($name, $value)
    {
        return self::$config[$name] = $value;
    }

    /**
     * @param $name
     * @param callable $updater
     * @return mixed
     */
    public static function updateItem($name, callable $updater)
    {
        return self::$config[$name] = $updater(self::getItem($name));
    }


}