<?php


require_once __DIR__ . '/poly.php';
require_once __DIR__ . '/libs.php';


function asset($path)
{
    return sprintf('./static/%s', ltrim($path, '/'));
}


// Override prod classes with dev ones if modifying feature
// class loaders work in order
if (is_dir(__DIR__ . '/features')) {
    autoload_register_namespace('Adminer', __DIR__ . '/features/');
}
autoload_register_namespace('', __DIR__);

require_once __DIR__ . '/config.php';
// config overrides (prod)
$mask = umask(0);
@touch(__DIR__ . '/config/config.php');
@chmod(__DIR__ . '/config/config.php', 0777);
@umask($mask);
@include __DIR__ . '/config/config.php';
