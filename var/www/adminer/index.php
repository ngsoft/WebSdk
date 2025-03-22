<?php

use Adminer\AdminerAutocomplete;
use Adminer\AdminerBootstrapSelect;
use Adminer\AdminerDisableJush;
use Adminer\AdminerLoginIp;
use Adminer\AdminerLoginServers;
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

    $plugins = [
        new ThemeSwitcher(),
        new AdminerDisableJush(),
        new AdminerAutocomplete(),
        new AdminerLoginIp(['127.0', '192.168', '::1']),
        new AdminerLoginServers(
            [
                'MySql' => ['driver' => 'mysql', 'server' => '127.0.0.1'],
                'PostgreSql' => ['driver' => 'pgsql', 'server' => '127.0.0.1'],
                'SqLite' => ['driver' => 'sqlite', 'server' => 'sqlite'],
            ],
            ['mysql', 'pgsql', 'sqlite'],
            __DIR__ . '/../../../tmp/adminer.servers',
            true,
            true
        ),

    ];

    $plugins[] = new AdminerBootstrapSelect($theme, $dark, $fix, $select);

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
