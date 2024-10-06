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

    private static $theme = null;


    public static function startAdminerSession()
    {
        $sid = "";
        if (isset($_COOKIE["adminer_sid"])) {
            $sid = $_COOKIE["adminer_sid"];
        }
        if (PHP_SESSION_ACTIVE !== session_status()) {
            if ($sid) {
                session_id($sid);
            }
            session_start();
        } elseif ($sid && $sid !== session_id()) {
            session_write_close();
            session_id($sid);
            session_start();
        }

        if (isset($_SESSION['themes']) && empty(self::$themeList)) {
            self::$themeList = $_SESSION['themes'];
        }
    }


    public static function isLoggedInAdminer()
    {
        self::startAdminerSession();


        $loggedIn = false;
        $pwds = isset($_SESSION['pwds']) ? $_SESSION['pwds'] : [];

        if (isset($pwds["server"])) {
            foreach ($pwds["server"] as $server) {
                foreach ($server as $list) {
                    if (is_array($list)) {
                        foreach ($list as $item) {
                            if (is_string($item)) {
                                $loggedIn = true;
                                break 3;
                            }
                        }
                    } elseif (is_string($list)) {
                        $loggedIn = true;
                        break 2;
                    }
                }

            }
        }

        return $loggedIn;
    }


    public static function getAdminerLocation()
    {
        return dirname(__DIR__);
    }

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
            $location = sprintf(self::BACKUP_LOCATION, self::getAdminerLocation());
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
            $location = sprintf(self::THEMES_LOCATION, self::getAdminerLocation());
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


    public static function loadJsonData($file = "adminer.json")
    {

        $data = [
            "theme" => "none",
            "type" => "none",
            "select" => false,
            "dark" => false,
        ];


        $file = self::getAdminerLocation() . DIRECTORY_SEPARATOR . $file;
        if (file_exists($file)) {
            $newData = json_decode(file_get_contents($file), true);
            foreach (array_keys($data) as $key) {
                if (gettype($data[$key]) === gettype($newData[$key])) {
                    $data[$key] = $newData[$key];
                }
            }
        }
        return $data;

    }

    public static function saveJsonData($file = "adminer.json", $type = "none", $theme = "none", $useBootstrapSelect = false, $darkMode = false)
    {

        $data = [
            "theme" => $theme,
            "type" => $type,
            "select" => $useBootstrapSelect,
            "dark" => $darkMode,
        ];
        $file = self::getAdminerLocation() . DIRECTORY_SEPARATOR . $file;

        return @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) > 0;
    }

    /**
     * @return string[]
     */
    public static function getThemeList()
    {

        self::startAdminerSession();
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
                if (mb_substr($file, -4) === '.css') {
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


    public static function getThemeOptionGroups()
    {
        $groups = [
            'Downloaded' => [],
            'Available' => self::getThemeList()
        ];

        $downloaded = &$groups['Downloaded'];
        $available = &$groups['Available'];

        $dlList = [];
        for ($i = count($available) - 1; $i >= 0; --$i) {
            $mtime = @filemtime(self::getBackupLocation($name = $available[$i]));
            if (0 < $mtime) {
                if (!isset($dlList[$mtime])) {
                    $dlList[$mtime] = [];
                }
                $dlList[$mtime][] = $name;
                array_splice($available, $i, 1);
            }
        }

        krsort($dlList);
        foreach ($dlList as $themes) {
            $downloaded = array_merge($downloaded, $themes);
        }
        return $groups;
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
        if (is_file($orig = self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE)) {

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


    public static function getCurrentAppliedTheme()
    {
        $value = "";
        $file = self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE;
        if (is_file($file) && $contents = @file_get_contents($file)) {
            $value = self::getCommentParam($contents, "themeName") ?: "";
        }
        return $value;
    }


    public static function setCommentParam($name, $value)
    {
        return sprintf('/** %s=`%s` */', $name, trim(json_encode($value), '"')) . "\n";
    }

    public static function getCommentParam($contents, $name)
    {
        if (preg_match(sprintf('#/[*]{2} (?:%s)=`(.+)` [*]/#', $name), $contents, $matches)) {

            $value = $matches[1];
            $normalized = json_decode($value, true);
            if (null === $normalized) {
                $normalized = $value;
            }
            return $normalized;
        }

        return null;
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
                // update mtime
                @touch($bck);

                $contents = self::setCommentParam("themeName", $name) . $contents;

                if (@file_put_contents($file = self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE, $contents)) {
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

        $themeList = self::getThemeList();
        $optGroups = self::getThemeOptionGroups();
        $current = self::getSelectedTheme();
        $groups = [];

        foreach ($optGroups as $groupName => $themes) {
            if (!isset($groups[$groupName])) {
                $groups[$groupName] = [];
            }

            foreach ($themes as $name) {
                $index = array_search($name, $themeList);
                if (false === $index) {
                    continue;
                }
                $groups[$groupName][$index] = $name;
            }
        }


        foreach ($groups as $label => $themes) {
            if (!count($themes)) {
                continue;
            }
            $options[] = sprintf('<optgroup label="%s">', $label);
            foreach ($themes as $index => $name) {
                $selected = "$index" === $current ? " selected " : "";
                $options[] = sprintf('<option value="%u"%s>%s</option>', $index, $selected, $name);
            }
            $options[] = '</optgroup>';
        }


        $options = implode('', $options);

        echo "<label class=\"fw-bold px-1 pb-2\" for=\"option-select\">Please Select a theme</label>
            <select name=\"option\" id=\"option-select\" placeholder=\"Select a theme...\" autocomplete=\"off\" class=\"form-select\">
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

    public static function removeTheme()
    {
        $file = self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE;
        @unlink($file);
        if (!is_file($file)) {
            return true;
        }
        return false;
    }


    public static function readActionFromBrowser()
    {
        $action = null;

        if (isset($_GET["action"])) {
            $value = $_GET["action"];
            if (false !== stripos($value, "default")) {
                $action = "remove";
            } elseif (false !== stripos($value, "select")) {
                $action = "select";
            }
        }
        return $action;
    }


    public static function readOptionFromBrowser()
    {
        if (self::readActionFromBrowser() !== "select") {
            return null;
        }

        if (isset($_GET['option'])) {
            self::$option = $_GET['option'];
        }

        return self::getOption();
    }


    public static function getSelectedTheme()
    {

        if (!isset(self::$theme)) {
            self::$theme = '';

            if (is_file($orig = self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE)) {

                $contents = @file_get_contents($orig);

                if ($current = self::getCommentParam($contents, "themeName")) {
                    $index = array_search($current, self::getThemeList());
                    if (is_int($index)) {
                        self::$theme = "$index";
                        return self::$theme;
                    }
                }

                $crc = crc32($contents);

                foreach (self::getThemeList() as $index => $name) {
                    if (is_file($path = self::getBackupLocation($name))) {
                        if ($crc === crc32(@file_get_contents($path) ?: '')) {
                            self::$theme = "$index";
                            break;
                        }
                    }
                }
            }
        }

        return self::$theme;
    }


    public static function runCommand()
    {
        self::startAdminerSession();
        self::displayListAvailableThemes();
        self::readOptionFromCommandLine();
        self::switchTheme();

        exit(0);
    }
}
