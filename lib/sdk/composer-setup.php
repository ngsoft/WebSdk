<?php

$file = (getenv('COMPOSER_HOME') ?: __DIR__ . '/../../etc/composer') . '/composer.json';

if (is_file($file))
{
    $data                   = json_decode(file_get_contents($file), true);
    $data['require'] ??= [];
    $data['require']['php'] = '>=7.4';
    $data['config']  ??= [];

    $data['config']         = array_replace($data['config'], [
        'sort-packages'   => true,
        'process-timeout' => 0,
    ]);

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}
