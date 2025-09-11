<?php

use Adminer\Config;

Config::setItem('ADMINER_VERSION', '5.4.0');
Config::setItem('ADMINER_ACL', ['127.0', '::1']);
Config::setItem('ADMINER_SAVEFILE', dirname(__DIR__, 4) . '/tmp/adminer.servers');
