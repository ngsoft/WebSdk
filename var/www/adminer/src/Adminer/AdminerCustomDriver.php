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

    /**
     * @param string  $key             Driver key
     * @param string  $name            Driver name
     * @param string  $file            PHP file to include
     * @param ?string $passwordLessKey passwordless key for secure login
     */
    public function __construct($key, $name, $file, $passwordLessKey = null)
    {
        $this->key             = $key;
        $this->name            = $name;
        $this->passwordLessKey = $passwordLessKey;
        $this->file            = $file;
    }

    public function loadDriver()
    {
        if ($this->loaded)
        {
            return;
        }
        $this->loaded      = true;
        $file              = $this->file;
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
