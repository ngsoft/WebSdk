<?php
error_reporting(0);
require_once __DIR__ . "/autoloader.php";
function adminer_object()
{

    if (isset($_SESSION["themeData"])) {
        $themeData = $_SESSION["themeData"];
    } else {
        $themeData = $_SESSION["themeData"] = ThemeSwitcher::loadJsonData();
    }


    $select = $themeData["select"];
    $dark = $themeData["dark"];
    $theme = $themeData["theme"];
    $type = $themeData["type"];

    $plugins = [
        new AdminerDisableJush(),
        new AdminerAutocomplete(),
        new AdminerLoginIp(['127.0', '192.168', '::1']),
        new AdminerLoginServers([], ['mysql'], __DIR__ . "/../../../tmp/adminer-servers"),
    ];

    if ($type === "custom") {
        $plugins[] = new AdminerTheme($theme);
    } elseif ($select) {
        $plugins[] = new AdminerBootstrapSelect($theme, $dark);
    }


    return new AdminerPlugin($plugins);
}


require_once __DIR__ . '/adminer.php';
