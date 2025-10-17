<?php

use Adminer\Config;

Config::setItem('ADMINER_ACL', ['127.0', '::1']);
Config::setItem('ADMINER_SAVEFILE', dirname(__DIR__, 4) . '/tmp/adminer.servers');
Config::setItem('ADMINER_ENUM_FOREIGN_LIMIT', 20); // 0 => unlimited
Config::setItem('ADMINER_ENUM_OPTIONS', false);
