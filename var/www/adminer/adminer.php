<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

use Adminer\AdminerPlugin;
use Adminer\Config;

require_once __DIR__ . '/src/functions.php';

function adminer_object()
{
    init_debug();
    return new AdminerPlugin((require_once __DIR__ . '/src/plugins.php'));
}

$version = Config::getItem('ADMINER_VERSION');
$archive = __DIR__ . "/dist/adminer-{$version}.zip";
$app = __DIR__ . "/dist/adminer-{$version}.php";
$extractor = require_once __DIR__ . '/src/extractor.php';

try {
    $extractor($archive, $app);
} catch (Exception $e) {
    $product = 'Adminer';
    $pageTitle = $product;
    $title = 'Extraction failed';
    $subTitle = basename($archive);
    $message = $e->getMessage();
    require __DIR__ . '/src/layout.php';
    exit;
}

require_once $app;