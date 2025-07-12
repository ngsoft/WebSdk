<?php


use Adminer\AdminerBackwardKeys;
use Adminer\AdminerBootstrapSelect;
use Adminer\AdminerCodemirror;
use Adminer\AdminerDatabaseHide;
use Adminer\AdminerDumpJson;
use Adminer\AdminerDumpPhp;
use Adminer\AdminerEditForeign;
use Adminer\AdminerEnumOption;
use Adminer\AdminerLoginIp;
use Adminer\AdminerLoginServers;
use Adminer\AdminerPrettyJsonColumn;
use Adminer\AdminerTablesFilter;
use Adminer\AdminerTheme;
use Adminer\Config;
use Adminer\ThemeSwitcher;

$plugins = [];


$plugins[] = new ThemeSwitcher();
$plugins[] = new AdminerEnumOption();
$plugins[] = new AdminerEditForeign();
$plugins[] = new AdminerBackwardKeys();
$plugins[] = new AdminerDumpJson();
$plugins[] = new AdminerDumpPhp();
$plugins[] = new AdminerPrettyJsonColumn();
$plugins[] = new AdminerCodemirror();
$plugins[] = new AdminerTablesFilter();
$plugins[] = new AdminerDatabaseHide(Config::getItem('HIDE_DATABASES', []));
$plugins[] = new AdminerLoginIp(Config::getItem('ADMINER_ACL', []));
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
