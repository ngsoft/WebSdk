<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

use Adminer\AdminerPlugin;
use Adminer\Config;

require_once __DIR__ . '/src/functions.php';

function adminer_object()
{
    init_debug();
    return new AdminerPlugin((require_once __DIR__ . '/src/plugins.php'));
}

$version = Config::getItem('ADMINER_VERSION');
require_once __DIR__ . "/dist/adminer-{$version}.php";