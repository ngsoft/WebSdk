<?php


use Adminer\AdminerBootstrapSelect;
use Adminer\AdminerTheme;
use Adminer\Config;
use Adminer\ThemeSwitcher;

require_once __DIR__ . '/libs-no-sql.php';
@include_once dirname(__DIR__) . '/vendor/autoload.php';

function init_debug($force = false)
{
    @ini_set("display_errors", 0);
    @error_reporting(0);
    if (class_exists(Config::class) && !defined('DEV_ENV')) {
        @define('DEV_ENV', Config::getItem('ADMINER_DEV', false));
    }

    // set debug mode for dev define('DEV_ENV', true); const DEV_ENV = true;
    if (constant_get('DEV_ENV', $force)) {
        @ini_set("display_errors", 1);
        // E_STRICT removed with php 8.4
        @error_reporting(24575);
        if (PHP_VERSION_ID < 80400) {
            @error_reporting(22527);
        }
    }
}

function asset($path)
{
    return sprintf('./static/%s', ltrim($path, '/'));
}

/**
 * @return AdminerBootstrapSelect|AdminerTheme
 */
function load_theme()
{
    static $key = 'theme-data';
    /** @var array{theme:string, type:"none"|"custom"|"adminer", select:bool, dark:bool,fix:bool,lang:bool} $data */
    $data = ThemeSwitcher::loadJsonData();
    if (!empty($_SESSION[$key])) {
        $data = $_SESSION[$key];
    }
    $_SESSION[$key] = $data;
    if ('custom' === $data['type']) {
        return new AdminerTheme($data['theme'], $data['fix'], $data['lang']);
    }
    return new AdminerBootstrapSelect($data['theme'], $data['dark'], $data['fix'], $data['select'], $data['lang']);

}

// Override prod classes with dev ones if modifying feature
// class loaders work in order
if (is_dir(__DIR__ . '/features')) {
    autoload_register_namespace('Adminer', __DIR__ . '/features/');
}
autoload_register_namespace('', __DIR__);

require_once __DIR__ . '/config.php';
// config overrides (prod)
tap(dirname(__DIR__) . '/config/config.php', function ($file) {
    if (!is_file($file)) {
        $mask = umask(0);
        @touch($file);
        @chmod($file, 0777);
        @umask($mask);
    }
    @include $file;
});


