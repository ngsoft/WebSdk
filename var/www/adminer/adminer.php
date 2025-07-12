<?php

use Adminer\Config;

$version = Config::getItem('ADMINER_VERSION');
require_once __DIR__ . "/dist/adminer-{$version}.php";