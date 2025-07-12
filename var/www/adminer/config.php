<?php


use Adminer\Config;

Config::setItem('ADMINER_VERSION', '5.3.0');
Config::setItem('HIDE_DATABASES', ['sys', 'mysql', 'information_schema', 'performance_schema']);
Config::setItem('ADMINER_ACL', ['127.0', '192.168', '::1']);

Config::setItem('ADMINER_DRIVERS', ['mysql', 'pgsql', 'sqlite']);
Config::setItem('ADMINER_SERVERS', [
    'MySql' => ['driver' => 'mysql', 'server' => '127.0.0.1'],
    'PostgreSql' => ['driver' => 'pgsql', 'server' => '127.0.0.1'],
    'SqLite' => ['driver' => 'sqlite', 'server' => 'sqlite'],
]);
Config::setItem('ADMINER_SAVEFILE', false);
Config::setItem('ADMINER_DYNAMIC_SERVERS', true);
Config::setItem('ADMINER_PASSWORDLESS', true);


