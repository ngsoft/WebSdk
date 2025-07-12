<?php

use Adminer\ThemeSwitcher;

ob_start();

require_once __DIR__ . "/functions.php";

$loggedIn = ThemeSwitcher::isLoggedInAdminer();

$redirect = null;
if ($loggedIn && isset($_SERVER["HTTP_REFERER"]) && false !== strpos($_SERVER["HTTP_REFERER"], "username")) {
    $redirect = $_SERVER["HTTP_REFERER"];
}

phpinfo();
$html = ob_get_clean();


$cgi = isset($_SERVER["FCGI_ROLE"]) ? " Fast CGI" : "";
ob_start(); ?>
    <title>PHP <?= PHP_VERSION . $cgi ?></title>
    <link rel="shortcut icon" href="./static/images/php.svg">
    <link rel="apple-touch-icon" href="./static/images/php.svg">
    <style>
        .return-link {
            height: 40px;
            width: 90vw;
            margin: 0 auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            max-width: 936px;
            background-color: rgb(79, 91, 147);
            border: 1px solid #222;

            font-size: 14px;
            position: fixed;
            z-index: 200;
            top: 0;
            left: calc(50% - 468px);

            a {
                padding: 0 8px;
                font-weight: 600;
                color: rgb(219, 225, 255);
                text-decoration: none;
                background: transparent;
                transition: color 0.25s ease-out;
            }

            a:hover,
            a:focus,
            a:active {
                color: rgb(249, 252, 255);
            }

        }


        .return-link ~ div.center {
            margin-top: 64px;
        }

        .php-logo {
            margin: 0 auto 0 8px;

            svg {
                width: auto;
                height: 32px;
            }
        }


        th {
            top: 40px;
        }

        .classic {
            .return-link {
                background-color: rgb(153, 153, 204);

                a {
                    color: #333;
                }

                a:hover {
                    color: #111;
                }
            }


        }


        table[width="600"] {
            width: 934px;
        }
    </style>

<?php
$head = ob_get_clean();

$body = "<body>";
if (PHP_VERSION_ID < 80000) {
    $body = '<body class="classic">';
}

$logo = "./static/images/php.svg";
$link = "https://www.php.net/releases/" . str_replace(".", "_", PHP_VERSION);
if (PHP_VERSION_ID > 80400) {
    $logo = "./static/images/php8.4.svg";
    $link = "https://www.php.net/releases/8.4";
} elseif (PHP_VERSION_ID > 80300) {
    $logo = "./static/images/php8.3.svg";
    $link = "https://www.php.net/releases/8.3";
} elseif (PHP_VERSION_ID > 80200) {
    $logo = "./static/images/php8.2.svg";
    $link = "https://www.php.net/releases/8.2";
} elseif (PHP_VERSION_ID > 80100) {
    $logo = "./static/images/php8.1.svg";
    $link = "https://www.php.net/releases/8.1";
}


ob_start(); ?>
    <div class="return-link">
        <a class="php-logo" href="<?= $link ?>" target="_blank">
            <?= @file_get_contents($logo) ?>
        </a>
        <?php if ($redirect) : ?>
            <a href="<?= $redirect ?>">Retour a Adminer</a>
        <?php endif; ?>
    </div>
<?php
$body .= ob_get_clean();


$html = preg_replace("#<title>(.*)</title>#i", $head, $html, 1);
$html = preg_replace("#<body>#i", $body, $html, 1);


echo $html;
