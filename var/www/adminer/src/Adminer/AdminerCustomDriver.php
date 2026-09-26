<?php

namespace Adminer;

class AdminerCustomDriver
{
    public $key;
    public $name;
    public $passwordLessKey = null;
    public $available       = false;
    private $file           = null;
    private $loaded         = false;
    private $evaluate       = null;

    /**
     * @param string               $key             Driver key
     * @param string               $name            Driver name
     * @param string               $file            PHP file to include
     * @param null|callable|string $passwordLessKey passwordless key for secure login or evaluate available closure
     * @param ?callable            $available       evaluate available closure
     */
    public function __construct($key, $name, $file, $passwordLessKey = null, $available = null)
    {
        $this->key  = $key;
        $this->name = $name;
        $this->file = $file;

        if (is_string($passwordLessKey))
        {
            $this->passwordLessKey = $passwordLessKey;
        } elseif ($passwordLessKey instanceof \Closure)
        {
            $available = $passwordLessKey;
        }

        if ($available instanceof \Closure)
        {
            $this->evaluate = $available;
        }
    }

    public function loadDriver()
    {
        if ($this->loaded)
        {
            return;
        }
        $this->loaded      = true;
        $file              = $this->file;

        $callback          = $this->evaluate;

        if ($callback && false === $callback())
        {
            return;
        }

        $driverDirectories = ['', __DIR__ . '/../drivers/', __DIR__ . '/../../config/drivers/'];

        foreach ($driverDirectories as $driverDirectory)
        {
            $location = realpath($driverDirectory . $file);

            if ($location && is_file($location))
            {
                $loaded          = @require_once $location;

                if (false === $loaded)
                {
                    return;
                }
                $this->available = true;
                $this->file      = $location;
                return;
            }
        }
    }
}
