<?php


use Adminer\AdminerBackwardKeys;
use Adminer\AdminerBootstrapSelect;
use Adminer\AdminerCodemirror;
use Adminer\AdminerColorFields;
use Adminer\AdminerDatabaseAutocomplete;
use Adminer\AdminerDatabaseHide;
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
use Adminer\AdminerTheme;
use Adminer\Config;
use Adminer\ThemeSwitcher;


$format_loaders = [
    'json' => AdminerDumpJson::class,
    'php' => AdminerDumpPhp::class,
    'md' => AdminerDumpMarkdown::class,
    'xlsx' => AdminerDumpXlsx::class,
];

$plugins = [];


$plugins[] = new ThemeSwitcher();
$plugins[] = new AdminerEnumOption();
$plugins[] = new AdminerEditForeign();
$plugins[] = new AdminerBackwardKeys();

// dump formats
foreach (array_unique(Config::getItem('ADMINER_EXTRA_DUMP_FORMATS', [])) as $dump_format) {
    if (isset($format_loaders[$dump_format])) {
        $plugins[] = new $format_loaders[$dump_format]();
    }
}

if (Config::getItem('ADMINER_COLOR_FIELDS')) {
    $plugins[] = new AdminerColorFields();
}

if (Config::getItem('ADMINER_JSON_PRETTY')) {
    $plugins[] = new AdminerPrettyJsonColumn();
}

$plugins[] = new AdminerCodemirror();

if (Config::getItem('ADMINER_TABLE_FILTER')) {
    $plugins[] = new AdminerTablesFilter();
}
if (Config::getItem('ADMINER_DATABASE_FILTER')) {
    $plugins[] = new AdminerDatabaseAutocomplete();
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

if (!empty($_SESSION['themeData'])) {
    $themeData = $_SESSION['themeData'];
} else {
    $themeData = $_SESSION['themeData'] = ThemeSwitcher::loadJsonData();
}

$plugins[] = new AdminerBootstrapSelect(
    $themeData['theme'],
    $themeData['dark'],
    $themeData['fix'],
    $themeData['select'],
    $themeData['lang']
);
if ('custom' === $themeData['type']) {
    $plugins[] = new AdminerTheme($themeData['theme']);
}


return $plugins;
