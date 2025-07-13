<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

use Adminer\AdminerPlugin;

require_once __DIR__ . '/functions.php';


function adminer_object()
{
    init_debug();
    return new AdminerPlugin((require_once __DIR__ . '/plugins.php'));
}


require_once __DIR__ . '/adminer.php';