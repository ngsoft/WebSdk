<?php


require_once __DIR__ . "/autoloader.php";

if (ThemeSwitcher::isRunningFromCommandLine()) {
    ThemeSwitcher::runCommand();
}

$loggedIn = false;
if (!empty($_COOKIE['adminer_sid'])) {
    ThemeSwitcher::startAdminerSession();

    $l = isset($_SESSION['pwds']) ? $_SESSION['pwds'] : [];

    foreach ($l as $_) {
        foreach ($_ as $__) {
            foreach ($__ as $___) {
                if (!$___) {
                    continue;
                }
                foreach ($___ as $pass) {
                    if (is_string($pass)) {
                        $loggedIn = true;
                        break 4;
                    }
                }
            }
        }
    }
}

if (!$loggedIn) {
    header('Location: ./');
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adminer theme selector</title>
    <?php if ("remove" !== ThemeSwitcher::readActionFromBrowser()): ?>
        <link rel="stylesheet" href="./<?= ThemeSwitcher::THEME_FILE ?>?<?= time() ?>">
    <?php endif; ?>
    <style>
        form {
            width: 90%;
            max-width: 600px;
            margin-left: 10%;
            height: 320px;
            user-select: none;
        }

        form fieldset {
            display: flex;
            flex-direction: column;
            row-gap: 16px;
            justify-content: center;
        }

        form label {
            font-weight: 700;
        }

        @media (max-width: 640px) {
            form {
                margin-left: auto;
                margin-right: auto;
            }

        }
    </style>
</head>

<body>
<div id="content">
    <?php if (null !== ThemeSwitcher::readOptionFromBrowser()) : ?>
        <h2>Download Adminer Theme</h2>
        <p class="links">
            <a href="?">Go back</a>
            <a href="./">Login to adminer</a>
        </p>
        <form>
            <fieldset>
                <legend>Download Result</legend>
                <div>
                    <?php ThemeSwitcher::switchTheme(); ?>
                </div>

            </fieldset>
        </form>
    <?php elseif ("remove" === ThemeSwitcher::readActionFromBrowser()) : ?>

        <h2>Download Adminer Theme</h2>
        <p class="links">
            <a href="?">Go back</a>
            <a href="./">Login to adminer</a>
        </p>
        <form>
            <fieldset>
                <legend>Download Result</legend>
                <div>
                    <?php ThemeSwitcher::printResultOf(ThemeSwitcher::removeTheme()); ?>
                </div>

            </fieldset>
        </form>

    <?php else : ?>
        <h2>List of available Adminer Themes</h2>
        <p class="links">
            <a href="./">Login to adminer</a>
        </p>
        <form method="GET" id="form-select-theme">
            <fieldset>
                <legend>Theme Selection</legend>
                <?php ThemeSwitcher::displayPageAvailableThemes(); ?>
                <div style="text-align: right;">
                    <input type="submit" name="action" value="Use Default Theme">
                    <input type="submit" name="action" value="Select Theme" class="switcher" disabled>
                </div>
            </fieldset>
        </form>
        <script>
            const
                btn = document.querySelector('[type="submit"].switcher'),
                select = document.getElementById('option-select');

            select.addEventListener('change', () => {
                btn.disabled = !select.value ? true : null;
            });
        </script>
    <?php endif; ?>
</div>
</body>

</html>