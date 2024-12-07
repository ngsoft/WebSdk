<!DOCTYPE html>
<html lang="en">

<head>
    <title>Welcome to nginx!</title>
    <style>
        html {
            color-scheme: light dark;
        }

        body {
            width: 35em;
            margin: 0 auto;
            font-family: Poppins, Tahoma, Verdana, Arial, sans-serif;
        }
    </style>
</head>

<body>
    <h1>Welcome to nginx!</h1>
    <p>If you see this page, the nginx web server is successfully installed and
        working.</p>

    <p>For online documentation and support please refer to
        <a href="http://nginx.org/">nginx.org</a>.<br />
        Commercial support is available at
        <a href="http://nginx.com/">nginx.com</a>.
    </p>

    <p><em>Thank you for using nginx.</em></p>
    <p>You are using PHP version <strong><?= PHP_VERSION ?></strong></p>
    <?php
    $apps = ['adminer', 'phpMyAdmin',];
    if (PHP_VERSION_ID < 70250) {
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
        }, 2000);
    </script>
</body>

</html>