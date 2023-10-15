<?php

if (PHP_VERSION_ID < 70000)
{
    // composer lts
    $__dir = getenv('COMPOSER_LTS_HOME');
} else
{
    $__dir = getenv('COMPOSER_HOME');
}

if (is_string($__dir) && is_file($__dir . '/vendor/autoload.php'))
{
    require_once $__dir . '/vendor/autoload.php';
}
