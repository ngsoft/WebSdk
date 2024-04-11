<?php


class ThemeSwitcher
{
    const THEMES_LOCATION = '%s/themes/';
    const BACKUP_LOCATION = '%s/themes/backup/';
    const GH_THEME_LIST = 'https://api.github.com/repos/vrana/adminer/contents/designs';
    const GH_THEME_DOWNLOAD = 'https://raw.githubusercontent.com/vrana/adminer/master/designs/%s/adminer.css';

    const PROMPT = 'Type the number of the theme you want to use: ';
    const THEME_FILE = 'adminer.css';
    public static $themeList = [];

    private static $option = '';

    public static function isRunningFromCommandLine()
    {
        return (php_sapi_name() === 'cli');
    }

    public static function isRunningOnWindows()
    {
        return (PHP_OS == 'WINNT');
    }

    public static function getBackupLocation($file = '')
    {
        static $location;

        if (!isset($location)) {
            $location = sprintf(self::BACKUP_LOCATION, __DIR__);
        }
        if (!is_dir($location)) {
            @mkdir($location, 0777, true);
        }

        if (empty($file)) {
            return $location;
        }
        return $location . "$file.css";
    }

    public static function getThemeLocation($theme = '')
    {
        static $location;

        if (!isset($location)) {
            $location = sprintf(self::THEMES_LOCATION, __DIR__);
        }
        if (empty($theme)) {
            return $location;
        }
        $fileName = $theme . '.css';

        if (is_file($result = $location . $fileName)) {
            return $result;
        }
        if (is_file($result = self::getBackupLocation() . $fileName)) {
            return $result;
        }

        return sprintf(self::GH_THEME_DOWNLOAD, $theme);
    }

    /**
     * @return string[]
     */
    public static function getThemeList()
    {

        if (empty(self::$themeList)) {
            $list = [];


            if (
                $json = @file_get_contents(
                    self::GH_THEME_LIST,
                    false,
                    stream_context_create([
                        'http' => [
                            'method' => 'GET',
                            'header' => [
                                'User-Agent: PHP'
                            ]
                        ],
                        'ssl' => [
                            "verify_peer" => false,
                            "verify_peer_name" => false
                        ]
                    ])
                )
            ) {

                foreach (json_decode($json) as $entry) {
                    if ($entry->type !== 'dir') {
                        continue;
                    }

                    $name = $entry->name;
                    $list[$name] = $name;
                }
            }

            foreach (scandir(self::getThemeLocation()) ?: [] as $file) {
                if (str_ends_with($file, '.css')) {
                    $name = mb_substr($file, 0, -4);
                    $list[$name] = $name;
                }
            }

            natsort($list);
            self::$themeList = array_values($list);

            // prevents api call on browsers
            if (!self::isRunningFromCommandLine() && count(self::$themeList) > 10) {
                $_SESSION['themes'] = self::$themeList;
            }
        }


        return self::$themeList;
    }


    public static function getLineEnding()
    {
        return (self::isRunningFromCommandLine() ? PHP_EOL : '');
    }


    public static function readOptionFromCommandLine()
    {
        if (self::isRunningOnWindows()) {
            echo self::PROMPT;
            self::$option = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            self::$option = readline(self::PROMPT);
        }

        return self::$option;
    }


    public static function makeBackup()
    {
        if (is_file($orig = __DIR__ . DIRECTORY_SEPARATOR . self::THEME_FILE)) {

            $dest = self::getBackupLocation(date('ymdHis'));
            @copy(
                $orig,
                $dest
            ) && @chmod($dest, 0777);
        }
    }


    public static function getThemeName($index)
    {
        $result = self::getThemeList();
        if (!isset($result[$index])) {
            return null;
        }
        return $result[$index];
    }


    public static function getOption()
    {
        if (!is_numeric(self::$option)) {
            return null;
        }
        return intval(self::$option);
    }


    public static function downloadTheme($index = null)
    {
        if (!isset($index)) {
            $index = self::getOption();
        }

        if (isset($index) && $name = self::getThemeName($index)) {
            self::makeBackup();
            if ($contents = file_get_contents($loc = self::getThemeLocation($name))) {
                $bck = self::getBackupLocation($name);

                if ($loc !== $bck) {
                    @file_put_contents($bck, $contents) && @chmod($bck, 0777);
                }

                if (@file_put_contents($file = __DIR__ . DIRECTORY_SEPARATOR . self::THEME_FILE, $contents)) {
                    @chmod($file, 0777);
                    return true;
                }
            }
        }

        return false;
    }

    public static function displayListAvailableThemes()
    {
        echo "List of available Adminer Themes:" . PHP_EOL . PHP_EOL;
        foreach (self::getThemeList() as $index => $name) {
            printf('[%u] %s' . PHP_EOL, $index, $name);
        }

        echo PHP_EOL;
    }

    public static function displayPageAvailableThemes()
    {
        $options = [];

        $options[] = '<option value="">Select a theme...</option>';

        foreach (self::getThemeList() as $index => $name) {
            $options[] = sprintf('<option value="%u">%s</option>', $index, $name);
        }


        $options = implode('', $options);

        echo "<label for=\"option-select\">Please Select a theme</label>
            <select name=\"option\" id=\"option-select\" placeholder=\"Select a theme...\" autocomplete=\"off\">
                {$options}
            </select>";
    }


    public static function printResultOf($download)
    {
        if ($download) {
            echo 'Theme switched successfully!' . PHP_EOL;
        } else {
            echo 'Something went wrong with the download. Try again!' . PHP_EOL;
            if (self::isRunningFromCommandLine()) {
                exit(1);
            }
        }
    }

    public static function printInvalidOptionErrorMessage()
    {
        $errorMessage = static::$option . " is not a number from the options! Try again!";
        if (self::isRunningFromCommandLine()) {
            echo $errorMessage . PHP_EOL;
            self::runCommand();
        }
        echo $errorMessage;
    }


    public static function switchTheme()
    {

        if (null === self::getOption()) {
            self::printInvalidOptionErrorMessage();
            return false;
        }
        self::printResultOf($result = self::downloadTheme());
        return $result;
    }


    public static function readOptionFromBrowser()
    {
        if (isset($_GET['option'])) {
            self::$option = $_GET['option'];
        }

        return self::getOption();
    }


    public static function runCommand()
    {
        self::displayListAvailableThemes();
        self::readOptionFromCommandLine();
        self::switchTheme();

        exit(0);
    }
}

if (ThemeSwitcher::isRunningFromCommandLine()) {
    ThemeSwitcher::runCommand();
}

$loggedIn = false;
if (!empty($_COOKIE['adminer_sid'])) {
    session_id($_COOKIE["adminer_sid"]);
    session_start();

    $l = isset($_SESSION['pwds']) ? $_SESSION['pwds'] : [];

    foreach ($l as $_) {
        foreach ($_ as $__) {
            foreach ($__ as $___) {
                foreach ($___ as $pass) {
                    if (is_string($pass)) {
                        $loggedIn = true;
                        break 2;
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
if (isset($_SESSION['themes'])) {
    ThemeSwitcher::$themeList = $_SESSION['themes'];
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
    <link rel="stylesheet" href="./<?= ThemeSwitcher::THEME_FILE ?>?<?= time() ?>">
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
                    <?php $result = ThemeSwitcher::switchTheme(); ?>
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
                    <input type="submit" value="Select Theme" disabled>
                </div>
            </fieldset>
        </form>
        <script>
            const
                btn = document.querySelector('[type="submit"]'),
                select = document.getElementById('option-select');


            select.addEventListener('change', () => {
                btn.disabled = null;
            });
        </script>
    <?php endif; ?>
</div>
</body>

</html>