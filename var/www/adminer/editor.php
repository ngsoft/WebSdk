<?php


use Adminer\Config;

require_once __DIR__ . '/functions.php';

$version = Config::getItem('ADMINER_VERSION');
require_once __DIR__ . "/dist/editor-{$version}.php";