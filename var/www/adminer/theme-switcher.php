<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adminer Theme Switcher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="./static/images/touchIcon-android.png">
    <script type="text/javascript">
        (function () {
            const darkMode = globalThis.matchMedia('(prefers-color-scheme: dark)');

            function setDarkMode() {
                document.documentElement.setAttribute("data-bs-theme", !darkMode.matches ? "dark" : "light");
            }

            darkMode.onchange = setDarkMode;
            setDarkMode();

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
<main class="container ">
    <div class="card bg-body-tertiary w-100 min-h-100">
        <?php if (!empty($title)): ?>
            <div class="card-header">
                <h5 class="card-title"><?= $title ?></h5>
                <?php if (!empty($subTitle)): ?>
                    <h6 class="card-subtitle text-body-secondary ms-2 fst-italic">Card subtitle</h6>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="card-body p-4">
            <?= !empty($body) ? $body : "" ?>
        </div>
    </div>

</main>
<footer></footer>
</body>
</html>