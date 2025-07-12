<?php

/**
 * ACL to protect proxied requests
 */
$validRemotes = ['::1', '127.0.0.1'];
$from = '';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $from = array_slice(preg_split('#[, ]#', $_SERVER['HTTP_X_FORWARDED_FOR']), -1)[0];
} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
    $from = $_SERVER['REMOTE_ADDR'];
}

if (!in_array($from, $validRemotes)) {
    header('Content-Type: text/plain', true, 403);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
$software = explode(" ", $_SERVER["SERVER_SOFTWARE"])[0];
$softwareType = strtolower(explode("/", $software)[0]);
$softwareVersion = explode("/", $software)[1];
$softwareName = ucfirst($softwareType);
$cgi = isset($_SERVER["FCGI_ROLE"]) ? " Fast CGI" : "";
?>

<head>
    <title>Welcome to <?= "$softwareName $softwareVersion" ?>!</title>
    <style>
        html {
            color-scheme: light dark;
        }

        body {
            width: 35em;
            margin: 0 auto;
            font-family: Poppins, Tahoma, Verdana, Arial, sans-serif;
        }

        small {
            margin-left: 16px;
            vertical-align: baseline;
        }
    </style>
</head>

<body>
    <h1>Welcome to <?= "$softwareName $softwareVersion" ?>!</h1>
    <p>If you see this page, the <?= $softwareType ?> web server is successfully installed and
        working.</p>
    <?php if ($softwareType === "nginx") : ?>
        <p>For online documentation and support please refer to
            <a target="_blank" href="http://nginx.org/">nginx.org</a>.<br />
            Commercial support is available at
            <a target="_blank" href="http://nginx.com/">nginx.com</a>.
        </p>


    <?php else : ?>
        <p>For online documentation and support please refer to
            <a target="_blank" href="https://httpd.apache.org/docs/2.4/">apache.org</a>.<br />
            User support is available at
            <a target="_blank" href="https://httpd.apache.org/support.html">apache.org</a>.
        </p>

    <?php endif; ?>
    <p><em>Thank you for using <?= $softwareType ?>.</em></p>
    <p>You are using PHP version
        <strong><?= PHP_VERSION . $cgi ?></strong>
        <small><?= PHP_VERSION_ID ?></small>
    </p>
    <?php
    $apps = ['phpMyAdmin', 'adminer',];
    if (PHP_VERSION_ID < 70250 || PHP_VERSION_ID > 80401) {
        $apps = ['adminer'];
    }
    foreach ($apps as $app) {
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'index.php')) {
            break;
        }
    }
    ?>
    <p><em>Redirecting to <?= $app ?> ...</em></p>
    <script>
        setTimeout(() => {
            location.href = `/<?= $app ?>`;
        }, 5000);
    </script>

</body>

</html>