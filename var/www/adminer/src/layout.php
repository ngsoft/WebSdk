<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars(isset($title) ? $title : ((isset($product) ? $product : 'Adminer') . ' Error'), ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="./static/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        #darkModeSwitch {
            background-image: none;
        }

        main {
            max-width: 840px !important;
        }

        main > .card:first-of-type {
        <?php if(isset($min_height) && $min_height): ?> min-height: 50vh;
        <?php else: ?> max-height: 50vh;
        <?php endif; ?>
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
</head>

<body class="d-flex flex-column min-vh-100 justify-content-evenly align-items-center bg-secondary-subtle">
<header>
    <?php if (!empty($pageTitle)): ?>
        <h1 class="text-body-secondary mb-0"><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
    <?php endif; ?>
</header>
<main class="container">
    <div class="card bg-body-tertiary w-100 min-h-100">
        <div class="card-header d-flex">
            <div>
                <?php if (!empty($title)): ?>
                    <h5 class="card-title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h5>
                    <?php if (!empty($subTitle)): ?>
                        <h6 class="card-subtitle text-body-secondary ms-2 fst-italic"><?= htmlspecialchars($subTitle, ENT_QUOTES, 'UTF-8'); ?></h6>
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
        <div class="card-body p-4<?= empty($message) && !empty($body) ? ' d-flex' : ''; ?>">
            <?php if (!empty($message)): ?>
                <div class="alert alert-danger mb-0" role="alert">
                    <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php elseif (!empty($body)): ?>
                <?= $body; ?>
            <?php endif; ?>
        </div>
    </div>
</main>
<footer><?= !empty($footer) ? $footer : ''; ?></footer>
</body>

</html>
