<?php

use Adminer\AdminerBackwardKeys;
use Adminer\AdminerCodemirror;
use Adminer\AdminerColorFields;
use Adminer\AdminerDatabaseFilter;
use Adminer\AdminerDatabaseHide;
use Adminer\AdminerDumpDate;
use Adminer\AdminerDumpJson;
use Adminer\AdminerDumpMarkdown;
use Adminer\AdminerDumpPhp;
use Adminer\AdminerDumpXlsx;
use Adminer\AdminerEditForeign;
use Adminer\AdminerEnumOption;
use Adminer\AdminerLoginIp;
use Adminer\AdminerLoginServers;
use Adminer\AdminerPrettyJsonColumn;
use Adminer\AdminerTablesFilter;
use Adminer\Config;
use Adminer\ThemeSwitcher;

$format_loaders = [
    'json' => AdminerDumpJson::class,
    'php' => AdminerDumpPhp::class,
    'md' => AdminerDumpMarkdown::class,
    'xlsx' => AdminerDumpXlsx::class,
];

$plugins = [];


$plugins[] = new ThemeSwitcher(
    Config::getItem('ADMINER_THEME_SWITCH', true),
    Config::getItem('ADMINER_PHP_INFO', true),
    Config::getItem('ADMINER_ADMIN_PAGE', false)
);
if (Config::getItem('ADMINER_ENUM_OPTIONS')) {
    $plugins[] = new AdminerEnumOption();
}

if (!in_array(Config::getItem('ADMINER_ENUM_FOREIGN_LIMIT'), [false, -1], true)) {
    $plugins[] = new AdminerEditForeign(Config::getItem('ADMINER_ENUM_FOREIGN_LIMIT', 0));
}
if (Config::getItem('ADMINER_FOREIGN_LINKS')) {
    $plugins[] = new AdminerBackwardKeys();
}

if (Config::getItem('ADMINER_DUMP_DATE')) {
    $plugins[] = new AdminerDumpDate();
}


// dump formats
if (Config::getItem('ADMINER_EXTRA_DUMP_FORMATS')) {
    foreach (array_unique(Config::getItem('ADMINER_EXTRA_DUMP_FORMATS', [])) as $dump_format) {
        if (isset($format_loaders[$dump_format])) {
            $plugins[] = new $format_loaders[$dump_format]();
        }
    }
}


if (Config::getItem('ADMINER_COLOR_FIELDS')) {
    $plugins[] = new AdminerColorFields();
}

if (Config::getItem('ADMINER_JSON_PRETTY')) {
    $plugins[] = new AdminerPrettyJsonColumn();
}

if (Config::getItem('ADMINER_AUTOCOMPLETE_QUERY')) {
    $plugins[] = new AdminerCodemirror();
}

if (Config::getItem('ADMINER_TABLE_FILTER')) {
    $plugins[] = new AdminerTablesFilter();
}
if (Config::getItem('ADMINER_DATABASE_FILTER')) {
    $plugins[] = new AdminerDatabaseFilter();
}

$plugins[] = new AdminerDatabaseHide(Config::getItem('HIDE_DATABASES', []));
$plugins[] = new AdminerLoginIp(
    Config::getItem('ADMINER_ACL', []),
    Config::getItem('ADMINER_TRUSTED_PROXY', [])
);
$plugins[] = new AdminerLoginServers(
    Config::getItem('ADMINER_SERVERS', []),
    Config::getItem('ADMINER_DRIVERS', []),
    Config::getItem('ADMINER_SAVEFILE', false),
    Config::getItem('ADMINER_DYNAMIC_SERVERS', false),
    Config::getItem('ADMINER_PASSWORDLESS', false)
);


// Themes
$plugins[] = load_theme();

return $plugins;
