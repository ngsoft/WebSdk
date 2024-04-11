<?php
ini_set('display_errors', 'Off');
// ini_set('memory_limit', '4096M');
// set_time_limit(600);

if (is_file(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
} else {
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
}


function adminer_object()
{
    return new AdminerPlugin([
        new AdminerDisableJush(),
        new AdminerAutocomplete(),
        new AdminerLoginIp(['127.0', '192.168', '::1']),

    ]);
}

require_once __DIR__ . '/adminer.php';
