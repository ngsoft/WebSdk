<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

use Adminer\AdminerPlugin;

require_once __DIR__ . '/functions.php';


function adminer_object()
{
    @ini_set("display_errors", 0);
    @error_reporting(0);

    // set debug mode for dev define('DEV_ENV', true); const DEV_ENV = true;
    if (constant_get('DEV_ENV')) {
        @ini_set("display_errors", 1);
        // E_STRICT removed with php 8.4
        @error_reporting(24575);
        if (PHP_VERSION_ID < 80400) {
            @error_reporting(22527);
        }
    }


    $plugins = require_once __DIR__ . '/plugins.php';

    return new AdminerPlugin($plugins);
}


require_once __DIR__ . '/adminer.php';