<?php
ini_set('display_errors', 'Off');
ini_set('memory_limit', '4096M');
set_time_limit(600);

require_once __DIR__ . '/../../vendor/autoload.php';
function adminer_object()
{
    return new AdminerPlugin([
        new AdminerLoginIp(['127.0', '192.168', '::1']),
    ]);
}

require_once __DIR__ . '/adminer.php';
