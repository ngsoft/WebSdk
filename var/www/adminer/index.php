<?php

use Adminer\AdminerBootstrapSelect;
use Adminer\AdminerTheme;
use Adminer\ThemeSwitcher;

error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/autoloader.php';
function adminer_object()
{

    error_reporting(0);
    ini_set('display_errors', 0);

    // error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    // ini_set("display_errors", 1);
    if (isset($_SESSION['themeData'])) {
        $themeData = $_SESSION['themeData'];
    } else {
        $themeData = $_SESSION['themeData'] = ThemeSwitcher::loadJsonData();
    }

    $select = $themeData['select'];
    $dark = $themeData['dark'];
    $theme = $themeData['theme'];
    $type = $themeData['type'];
    $fix = $themeData['fix'];
    $lang = $themeData['lang'];

    $plugins = require_once __DIR__ . "/plugins.php";

    array_unshift($plugins, new ThemeSwitcher());
    $plugins[] = new AdminerBootstrapSelect($theme, $dark, $fix, $select, $lang);

    if ('custom' === $type) {
        $plugins[] = new AdminerTheme($theme);
    }

    if (class_exists("Adminer\\Adminer")) {
        $instance = new \Adminer\AdminerPlugin($plugins);
    } else {
        $instance = new AdminerPlugin($plugins);
    }

    return $instance;
}


require_once __DIR__ . '/adminer.php';
