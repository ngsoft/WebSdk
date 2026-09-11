<?php

use Adminer\Config;

Config::setItem('ADMINER_ACL', ['127.0', '::1']);
Config::setItem('ADMINER_SAVEFILE', dirname(__DIR__, 4) . '/tmp/adminer.servers');
Config::setItem('ADMINER_ENUM_FOREIGN_LIMIT', 20); // 0 => unlimited
Config::setItem('ADMINER_ENUM_OPTIONS', false);
Config::setItem('ADMINER_DRIVERS', ['mysql', 'pgsql', 'sqlite', 'redis']);
Config::setItem('ADMINER_SERVERS', [
    'MySql' => ['driver' => 'mysql', 'server' => '127.0.0.1'],
    'PostgreSql' => ['driver' => 'pgsql', 'server' => '127.0.0.1'],
    'SqLite' => ['driver' => 'sqlite', 'server' => 'sqlite'],
    'Redis' => ['driver' => 'redis', 'server' => '127.0.0.1'],
]);

