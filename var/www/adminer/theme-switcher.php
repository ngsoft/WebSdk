<?php
ob_start();

require_once __DIR__ . "/autoloader.php";

function renderArgs($arguments, $prefix = '')
{
    $result = [];

    if (!is_string($prefix)) {
        throw new InvalidArgumentException('$prefix is not a string');
    }

    // is_iterable() for php < 7.1
    if (!is_array($arguments) && !($arguments instanceof Traversable)) {
        throw new InvalidArgumentException('$arguments is not iterable');
    }

    foreach ($arguments as $key => $value) {
        if (false === $value || null === $value) {
            continue;
        }

        // dataset helper
        if ('data' === $key && (is_array($value) || $value instanceof Traversable)) {
            if ($tmp = renderArgs($value, 'data-')) {
                $result[] = $tmp;
            }
            continue;
        }

        if (!is_scalar($value)) {
            continue;
        }

        if (!is_string($key)) {
            if (!is_string($value)) {
                continue;
            }
            $key = $value;
            $value = true;
        }

        $renderKey = preg_replace_callback(
            '#[A-Z]#',
            function ($matches) {
                return '-' . strtolower($matches[0]);
            },
            lcfirst($prefix . $key)
        );

        if (true === $value) {
            $result[$renderKey] = $renderKey;
            continue;
        }

        if (!is_string($value)) {
            $value = json_encode($value);
        }

        $result[$renderKey] = sprintf('%s="%s"', $renderKey, $value);
    }

    return implode(' ', $result);
}

$loggedIn = ThemeSwitcher::isLoggedInAdminer();


if ($loggedIn && isset($_SERVER["HTTP_REFERER"]) && false !== strpos($_SERVER["HTTP_REFERER"], "username")) {
    $_SESSION["redirectAdminer"] = $_SERVER["HTTP_REFERER"];
}


unset($_SESSION["themeData"]);
$currentData = ThemeSwitcher::loadJsonData();
$customThemes = [
    "default-blue" => "Custom Adminer Blue",
    "default-green" => "Custom Adminer Green",
    "default-orange" => "Custom Adminer Orange",
];

$title = "Adminer Theme Switcher";


$action = "default";
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

if ($action === "redirect"):
    $location = "./";
    if ($loggedIn && isset($_SESSION["redirectAdminer"])) {
        $location = $_SESSION["redirectAdminer"];
        unset($_SESSION["redirectAdminer"]);

    }
    header("Location: $location");
    exit;
elseif (!$loggedIn) :?>

    <div class="d-flex flex-column justify-content-between w-100">

        <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
            <div class="h3 mb-4">
                You are not logged in
            </div>
            <div>
                You must first sign in to change adminer theme.
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center mt-auto w-100">
            <div>
                <a href="./" class="btn btn-outline-primary text-capitalize">Login</a>
            </div>
        </div>

    </div>
<?php elseif ($action === "default") :
    $subTitle = "Select your theme";
    ?>
    <form method="get" class="d-flex flex-column w-100">
        <input type="hidden" name="action" value="apply">

        <div class="mb-2">
            <label for="themeType" class="px-1 pb-2 fw-bold">Choose Theme Type</label>
            <select class="form-select" id="themeType" name="type">

                <optgroup label="Select theme type">

                    <option <?= renderArgs(["selected" => $currentData["type"] === "none", "value" => "none"]) ?>>
                        Adminer default
                        theme
                    </option>
                    <option
                        <?= renderArgs(["selected" => $currentData["type"] === "custom", "value" => "custom"]) ?>>
                        Custom theme
                    </option>
                    <option
                        <?= renderArgs(["selected" => $currentData["type"] === "adminer", "value" => "adminer"]) ?>>
                        Adminer theme
                    </option>
                </optgroup>
            </select>
        </div>

        <div class="my-2 d-none" data-type="custom">
            <label for="themeType" class="px-1 pb-2 fw-bold">Choose Theme Variant</label>
            <select class="form-select" id="themeType" name="nameCustom">
                <option value="">Choose variant</option>
                <?php foreach ($customThemes as $val => $label) : ?>
                    <option <?= renderArgs(["selected" => $currentData["theme"] === $val, "value" => $val]) ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="my-2 d-none" data-type="adminer">
            <?php ThemeSwitcher::displayPageAvailableThemes() ?>
        </div>

        <div class="my-2 px-2 d-none" data-type="none,adminer">
            <div class="form-check form-switch mb-2">
                <input class="form-check-input cursor-pointer" <?= renderArgs(["checked" => $currentData["select"]]) ?>
                       type="checkbox"
                       role="switch" id="bsSelectOn" name="bsSelectOn">
                <label class="form-check-label cursor-pointer fw-bold" for="bsSelectOn">Use Bootstrap Select
                    plugin</label>
            </div>
            <div class="form-check form-switch mb-2">
                <input class="form-check-input cursor-pointer" <?= renderArgs(["checked" => $currentData["fix"]]) ?>
                       type="checkbox"
                       role="switch" id="bsSelectFix" name="bsSelectFix">
                <label class="form-check-label cursor-pointer fw-bold" for="bsSelectFix">Fix input sizes</label>
            </div>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input cursor-pointer" <?= renderArgs(["checked" => $currentData["dark"]]) ?>
                       type="checkbox"
                       role="switch" id="bsSelectDark" name="bsSelectDark">
                <label class="form-check-label cursor-pointer fw-bold" for="bsSelectDark">Theme is dark</label>
            </div>


        </div>

        <div class="d-flex justify-content-between align-items-center mt-auto">
            <div>
                <a href="?action=redirect" class="btn btn-outline-secondary text-capitalize">Go back to adminer</a>
            </div>
            <div>
                <button type="submit" id="submitForm" class="btn btn-outline-success" disabled>
                    Change theme
                </button>
            </div>
        </div>
    </form>

    <script>
        const
            themeTypeSelect = document.getElementById("themeType"),
            btn = document.getElementById("submitForm");

        function changeType(value) {
            document.querySelectorAll('[data-type]').forEach(elem => {
                const types = elem.dataset.type.split(",");
                if (types.includes(value)) {
                    elem.classList.remove("d-none");
                } else {
                    elem.classList.add("d-none");
                }

                btn.disabled = true;
                if (value === "none") {
                    btn.disabled = null;
                }
            });
        }

        themeTypeSelect.addEventListener("change", ({target}) => {
            changeType(target.value);
        });

        document.querySelector("form").addEventListener("change", ({target}) => {
            let t = target.closest('[data-type] input, [data-type] select');
            if (t) {
                btn.disabled = t.value === "" ? true : null;
            }
        });


        changeType(`<?= $currentData['type'] ?>`);
        btn.disabled = true;
    </script>
<?php elseif ($action === "apply") :
$_GET["action"] = "select";
$ok = false;
$type = $_GET['type'];
$select = isset($_GET["bsSelectOn"]);
$dark = isset($_GET["bsSelectDark"]);
$fix = isset($_GET["bsSelectFix"]);

$theme = "none";
if ($type === "custom") {
    if (isset($customThemes[$_GET["nameCustom"]])) {
        $theme = $_GET["nameCustom"];
        $ok = true;
    }
} else if ($type === "adminer") {
    ThemeSwitcher::readOptionFromBrowser();
    $admTheme = ThemeSwitcher::getThemeName(ThemeSwitcher::getOption());
    if ($admTheme) {
        $theme = $admTheme;
        $ok = true;
    }
} else if ($type === "none") {
    $ok = true;
}

if (!$select || $type === "custom") {
    $select = $fix = $dark = false;
}
if ($ok && $ok = ThemeSwitcher::saveJsonData("adminer.json", $type, $theme, $select, $dark, $fix)) {

    switch ($type) {
        case "none":
            $ok = ThemeSwitcher::removeTheme();
            break;
        case "adminer":
            $ok = ThemeSwitcher::downloadTheme();
    }
}
?>
<div class="d-flex flex-column justify-content-between w-100">

    <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
        <?php if ($ok):
            if ("none" !== $type) : ?>
                <div class="h3 mb-4">
                    Your theme has been applied
                </div>
                <div>
                    Your <em><?= $type ?></em> theme <strong><?= $theme ?></strong> has been applied
                </div>
            <?php else : ?>
                <div class="h3 mb-4">
                    Your theme has been reset
                </div>
                <div>
                    Adminer theme has been reset to defaults
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="h3 mb-4">
                An error occurred
            </div>
            <div>
                Something went wrong with the download. Try again!
            </div>
        <?php endif; ?>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-auto w-100">
        <div>
            <a href="?" class="btn btn-outline-secondary text-capitalize">Change theme</a>
        </div>

        <div>
            <a href="?action=redirect" class="btn btn-outline-primary text-capitalize">Go back to adminer</a>
        </div>

    </div>

</div>


<?php endif;
$body = ob_get_clean();
?><!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adminer Theme Switcher</title>
    <link href="./static/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        #darkModeSwitch {
            background-image: none;
        }
    </style>
    <link rel="icon" href="./static/images/touchIcon-android.png">
    <script type="module">
        (function () {
            const
                darkMode = globalThis.matchMedia('(prefers-color-scheme: dark)'),
                darkModeSwitch = document.getElementById("darkModeSwitch"),
                darkModeSwitchLabel = darkModeSwitch.previousElementSibling,
                userSelectedValueKey = "adminerThemeSwitcherDarkMode",
                darkModeRangeLabels = ["auto", "off", "on"];

            let isDark = null;

            function getUserSelectedValue() {
                return localStorage.getItem(userSelectedValueKey) ?? "auto";
            }

            function updateSwitch() {
                darkModeSwitchLabel.innerHTML = getUserSelectedValue();
                setDarkMode();
            }

            function setDarkMode() {
                const userValue = getUserSelectedValue();
                isDark = darkMode.matches;
                if (userValue !== "auto") {
                    isDark = userValue === "on";
                }
                document.documentElement.setAttribute("data-bs-theme", isDark ? "dark" : "light");
            }


            darkModeSwitch.addEventListener("change", () => {
                let index = JSON.parse("" + darkModeSwitch.value),
                    value = darkModeRangeLabels[index];
                localStorage.setItem(userSelectedValueKey, value)
                updateSwitch();
            });


            darkModeSwitch.value = darkModeRangeLabels.indexOf(getUserSelectedValue())
            darkMode.onchange = setDarkMode;
            updateSwitch();
        })();
    </script>
    <style>
        main {
            max-width: 840px !important;
        }

        main > .card:first-of-type {
            min-height: 50vh;
        }
    </style>

</head>

<body class="d-flex flex-column min-vh-100 justify-content-evenly align-items-center bg-secondary-subtle">
<header>
    <?php if (!empty($pageTitle)): ?>
        <h1 class="text-body-secondary mb-0"><?= $pageTitle ?></h1>
    <?php endif; ?>
</header>
<main class="container">
    <div class="card bg-body-tertiary w-100 min-h-100">
        <div class="card-header d-flex">

            <div>
                <?php if (!empty($title)): ?>
                    <h5 class="card-title"><?= $title ?></h5>
                    <?php if (!empty($subTitle)): ?>
                        <h6 class="card-subtitle text-body-secondary ms-2 fst-italic"><?= $subTitle ?></h6>
                    <?php endif;
                endif; ?>
            </div>


            <div class="form-check form-switch ms-auto user-select-none">
                <label class="form-check-label visually-hidden" for="darkModeSwitch">Dark Mode</label>
                <div class="d-flex align-items-center">
                    <div class="text-uppercase cursor-pointer"></div>
                    <input class="form-check-input cursor-pointer ms-2" type="range" min="0" max="2" id="darkModeSwitch"
                           title="Toggle dark Mode">
                </div>


            </div>
        </div>


        <div class="card-body p-4 d-flex">
            <?= !empty($body) ? $body : "" ?>
        </div>
    </div>

</main>
<footer><?= !empty($footer) ? $footer : "" ?></footer>
</body>

</html>