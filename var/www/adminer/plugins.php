<?php

use Adminer\AdminerAutocomplete;
use Adminer\AdminerCodemirror;
use Adminer\AdminerDisableJush;
use Adminer\AdminerDumpJson;
use Adminer\AdminerDumpPhp;
use Adminer\AdminerEnumOption;
use Adminer\AdminerJsonColumn;
use Adminer\AdminerLoginIp;
use Adminer\AdminerLoginServers;
use Adminer\AdminerPrettyJsonColumn;
use Adminer\AdminerDatabaseHide;
use Adminer\AdminerTablesFilter;

$plugins = [];


$plugins[] = new AdminerEnumOption();
$plugins[] = new AdminerDumpJson();
$plugins[] = new AdminerDumpPhp();

if (class_exists("Adminer\\Adminer")) {
    $plugins[] = new AdminerPrettyJsonColumn();
    $plugins[] = new AdminerCodemirror();
} else {
    $plugins[] = new AdminerJsonColumn();
    $plugins[] = new AdminerDisableJush();
    $plugins[] = new AdminerAutocomplete();
}



$plugins[] = new AdminerTablesFilter();
$plugins[] = new AdminerDatabaseHide(['sys', 'mysql', 'information_schema', 'performance_schema']);
$plugins[] = new AdminerLoginIp(['127.0', '192.168', '::1']);
$plugins[] = new AdminerLoginServers(
    [
        'MySql' => ['driver' => 'mysql', 'server' => '127.0.0.1'],
        'PostgreSql' => ['driver' => 'pgsql', 'server' => '127.0.0.1'],
        'SqLite' => ['driver' => 'sqlite', 'server' => 'sqlite'],
    ],
    ['mysql', 'pgsql', 'sqlite'],
    __DIR__ . '/../../../tmp/adminer.servers',
    true,
    true
);

return $plugins;
