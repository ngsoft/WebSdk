<?php


use Adminer\Config;


Config::setItem('ADMINER_DEV', false);
Config::setItem('ADMINER_VERSION', '5.4.2');
Config::setItem('HIDE_DATABASES', ['sys', 'mysql', 'information_schema', 'performance_schema']);
Config::setItem('ADMINER_ACL', ['127.0', '192.168', '::1']);
Config::setItem('ADMINER_TRUSTED_PROXY', []);

Config::setItem('ADMINER_DRIVERS', ['mysql', 'pgsql', 'sqlite']);
Config::setItem('ADMINER_SERVERS', [
    'MySql' => ['driver' => 'mysql', 'server' => '127.0.0.1'],
    'PostgreSql' => ['driver' => 'pgsql', 'server' => '127.0.0.1'],
    'SqLite' => ['driver' => 'sqlite', 'server' => 'sqlite'],
]);
Config::setItem('ADMINER_SAVEFILE', false);
Config::setItem('ADMINER_DYNAMIC_SERVERS', true);
Config::setItem('ADMINER_PASSWORDLESS', true);
Config::setItem('ADMINER_DUMP_DATE', true);
Config::setItem('ADMINER_EXTRA_DUMP_FORMATS', ['json', 'md', 'php']);
Config::setItem('ADMINER_COLOR_FIELDS', true);
Config::setItem('ADMINER_JSON_PRETTY', true);
Config::setItem('ADMINER_TABLE_FILTER', true);
Config::setItem('ADMINER_DATABASE_FILTER', true);
Config::setItem('ADMINER_THEME_SWITCH', true);
Config::setItem('ADMINER_PHP_INFO', true);
Config::setItem('ADMINER_ADMIN_PAGE', true);
Config::setItem('ADMINER_ENUM_FOREIGN_LIMIT', 0); // unlimited
Config::setItem('ADMINER_ENUM_OPTIONS', true);
Config::setItem('ADMINER_FOREIGN_LINKS', true);
Config::setItem('ADMINER_AUTOCOMPLETE_QUERY', true);
