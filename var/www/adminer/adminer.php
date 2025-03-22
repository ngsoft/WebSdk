<?php

require_once __DIR__ . "/config.php";

$version = ADMINER_VERSION;

if (PHP_VERSION_ID < 70000 && $version === "evo") {
    $version = "legacy";
}
require_once __DIR__ . "/adminer-{$version}.php";
