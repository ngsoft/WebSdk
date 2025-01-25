<?php


require_once __DIR__ . "/functions.php";
/**
 * Basic PSR-4 autoloader
 */
spl_autoload_register(function ($className) {
    $path = [
        ['', __DIR__ . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR]
    ];
    $filename = str_replace("\\", '/', $className);
    foreach ($path as list($prefix, $root)) {
        $len = strlen($prefix);
        $checkPrefix = substr($className, 0, $len);
        if ($prefix === $checkPrefix) {
            $filepath = $root . substr($filename, $len) . '.php';
            if (is_file($filepath)) {
                require_once $filepath;
            }
        }
    }
});
