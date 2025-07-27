<?php

namespace Adminer;

/**
 * Manages adminer themes
 */
class ThemeSwitcher
{
    const THEMES_LOCATION = '%s/themes/';
    const BACKUP_LOCATION = '%s/themes/backup/';
    const GH_THEME_LIST = 'https://api.github.com/repos/%s/contents/designs';
    const GH_THEME_DOWNLOAD = 'https://raw.githubusercontent.com/%s/master/designs/%s/adminer.css';
    const GH_THEME_DOWNLOAD_ALT = 'https://raw.githubusercontent.com/%s/master/designs/%s/adminer-dark.css';

    const PROMPT = 'Type the number of the theme you want to use: ';
    const THEME_FILE = 'adminer.css';
    const THEME_FILE_DARK = 'adminer-dark.css';

    private static $icons = [
        '<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960" fill="currentColor"><path d="M680-80q-83 0-141.5-58.5T480-280q0-83 58.5-141.5T680-480q83 0 141.5 58.5T880-280q0 83-58.5 141.5T680-80Zm88-114q5-5 2.5-12t-9.5-8q-26-5-48.5-19.5T676-272q-14-24-15.5-51t7.5-52q2-7-2.5-12.5T654-391q-67 12-91.5 76T582-196q35 44 92 45t94-43ZM480-480ZM370-80l-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-74 56q-22-11-45-18.5T714-558l63-48-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q17 17 36.5 30.5T400-275q1 57 23.5 107T484-80H370Zm41-279q6-20 14.5-38.5T445-433q-11-8-17-20.5t-6-26.5q0-25 17.5-42.5T482-540q14 0 27 6.5t21 17.5q17-11 35-19.5t38-13.5q-18-32-50-51.5T482-620q-59 0-99.5 41T342-480q0 38 18.5 70.5T411-359Z"/></svg>',
        '<svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960" fill="currentColor"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>'
    ];

    public static $themeList = [];
    private static $option = '';
    private static $theme = null;

    public static $knownDarkThemes = [
        'adminer-dark',
        'dracula',
        'galkaev',
        'mancave',
    ];

    public static $product = "Adminer";
    public static $repo = [
        "Adminer" => "vrana/adminer"
    ];

    public static $selectedDark = false;


    private $info = true;
    private $switch = true;

    private $admin = true;

    /**
     * @param bool $switch Display switch
     * @param bool $info Display php info
     */
    public function __construct($switch = true, $info = true, $admin = true)
    {
        $this->switch = $switch;
        $this->info = $info;
        $this->admin = $admin;
    }

    public function head()
    {


        /*`<a title="Switch theme" class="theme-switcher-link" href="./theme-switcher.php?action=select-theme&token=<?= $token ?>&product=${product}"><?=self::$icons[0] ?></a>`,*/
        /*`<a title="PHP Info" class="theme-switcher-link" href="./info.php?token=<?= $token ?>"><?=self::$icons[1] ?></a>`*/

        //[
        /*`<a title="Switch theme" class="theme-switcher-link" href="./theme-switcher.php?action=select-theme&token=<?= $token ?>&product=${product}"><?=self::$icons[0] ?></a>`,*/
        /*`<a title="PHP Info" class="theme-switcher-link" href="./info.php?token=<?= $token ?>"><?=self::$icons[1] ?></a>`*/
        //].join('');

        $token = "";
        if (isset($_SESSION["token"])) {
            $token = $_SESSION["token"];
        }

        $code = [];
        if ($this->switch) {
            $code[] = renderTag('a', [
                "title" => "Switch theme",
                "class" => "theme-switcher-link",
                "href" => sprintf('./theme-switcher.php?action=select-theme&token=%s&product=%s', $token, self::$product),
            ], self::$icons[0]);
        }

        if ($this->info) {
            $code[] = renderTag('a', [
                "title" => "PHP Info",
                "class" => "theme-switcher-link",
                "href" => sprintf('./info.php?token=%s', $token),
            ], self::$icons[1]);
        }
        $code = implode('', $code);
        ?>
        <script <?= nonce(); ?> type="text/javascript">
            addEventListener("DOMContentLoaded", () => {
                let
                    menu = document.getElementById('menu'),
                    h1 = menu.querySelector("h1"),
                    hasLinks = menu.querySelector('.links') !== null && h1 !== null;
                if (hasLinks) {
                    const c = document.createElement('div');
                    c.style = `padding: 8px; margin-bottom:2px; display:flex; column-gap:8px;justify-content: space-between;`;
                    c.innerHTML = `<?= $code ?>`;
                    h1.parentElement.insertBefore(c, h1.nextElementSibling)
                }

            });
        </script>
        <style <?= nonce() ?>>
            .links {
                display: flex;
                flex-wrap: wrap;
            }

            #menu > h1 {
                border-top: 1px solid transparent;
            }

            .theme-switcher-link {
                display: flex;
                align-items: center;
                column-gap: 4px;
                transition: color .25s;
            }

            .theme-switcher-link:before, .theme-switcher-link:after {
                transition: content 0.5s;
            }

            .theme-switcher-link:hover:after,
            .theme-switcher-link:focus:after,
            .theme-switcher-link:active:after,
            .theme-switcher-link:last-child:not(:first-child):hover:before,
            .theme-switcher-link:last-child:not(:first-child):focus:before,
            .theme-switcher-link:last-child:not(:first-child):active:before {
                content: attr(title);
                display: block;
            }

            .theme-switcher-link:hover:last-child:not(:first-child):after,
            .theme-switcher-link:focus:last-child:not(:first-child):after,
            .theme-switcher-link:active:last-child:not(:first-child):after {
                content: none;
            }
        </style>
        <?php
    }


    public static function startAdminerSession()
    {

        static $ok = false;

        if ($ok) {
            return;
        }
        $ok = true;

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

        if (empty(self::$themeList[self::$product]) && isset($_SESSION['themes'][self::$product])) {
            self::$themeList = $_SESSION['themes'][self::$product];
        }
    }


    public static function isLoggedInAdminer()
    {
        self::startAdminerSession();

        if (!isset($_SESSION["token"])) {
            return false;
        }

        if (isset($_REQUEST["token"]) && strval($_SESSION["token"]) === $_REQUEST["token"]) {
            $_SESSION["connectedAdminer"] = date("Y-m-d H:i:s", time() + 600);
            return true;
        }
        if (isset($_SESSION["connectedAdminer"]) && strtotime($_SESSION["connectedAdminer"]) > time()) {
            return true;
        }
        unset($_SESSION["connectedAdminer"]);
        return false;
    }


    public static function getRepo($type = null)
    {

        $versions = array_keys(self::$repo);

        if ($type === null) {
            $type = self::$product;
        }


        foreach ($versions as $version) {
            if (strtolower($type) === strtolower($version)) {
                return self::$repo[$version];
            }
        }
        return self::$repo["Adminer"];
    }


    public static function getAdminerLocation()
    {
        return constant_get('ADMINER_LOCATION', dirname(dirname(__DIR__)));
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

        $product = &self::$product;

        return $location . mb_strtolower("$file-$product.css");
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

        return sprintf(self::GH_THEME_DOWNLOAD, self::getRepo(), $theme);
    }

    public static function getAltThemeLocation($theme)
    {
        return sprintf(self::GH_THEME_DOWNLOAD_ALT, self::getRepo(), $theme);
    }


    /**
     * @param $file
     * @return array{theme:string, type:"none"|"custom"|"adminer", select:bool, dark:bool,fix:bool,lang:bool}
     */
    public static function loadJsonData($file = "config/adminer.json")
    {

        $data = [
            "theme" => "none",
            "type" => "none",
            "select" => false,
            "dark" => false,
            "fix" => false,
            "lang" => true
        ];


        $file = self::getAdminerLocation() . DIRECTORY_SEPARATOR . $file;

        if (is_file($file)) {
            $newData = json_decode(file_get_contents($file), true);
            foreach (array_keys($data) as $key) {
                if (isset($newData[$key]) && gettype($data[$key]) === gettype($newData[$key])) {
                    $data[$key] = $newData[$key];
                }
            }
        }

        return $data;
    }

    /**
     * @param string $file
     * @param "none"|"custom"|"adminer" $type
     * @param string $theme
     * @param bool $useBootstrapSelect
     * @param bool $darkMode
     * @param bool $fix
     * @param bool $lang
     * @return bool
     */
    public static function saveJsonData($file = "config/adminer.json", $type = "none", $theme = "none", $useBootstrapSelect = false, $darkMode = false, $fix = false, $lang = true)
    {

        $data = [
            "theme" => $theme,
            "type" => $type,
            "select" => $useBootstrapSelect,
            "dark" => $darkMode,
            "fix" => $fix,
            "lang" => $lang
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
        if (empty(self::$themeList[self::$product])) {
            $list = [];


            if (
                $json = @file_get_contents(
                    sprintf(self::GH_THEME_LIST, self::getRepo()),
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
            self::$themeList[self::$product] = array_values($list);

            // prevents api call on browsers
            if (!self::isRunningFromCommandLine() && count(self::$themeList[self::$product]) > 10) {
                $_SESSION['themes'] = self::$themeList;
            }
        }


        return self::$themeList[self::$product];
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
            $mask = umask(0);
            @copy(
                $orig,
                $dest
            ) && @chmod($dest, 0777);
            @umask($mask);
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

    /**
     * @return bool
     */
    public static function isSelectedDark()
    {
        return self::$selectedDark;
    }


    public static function downloadTheme($index = null)
    {
        if (!isset($index)) {
            $index = self::getOption();
        }

        if (isset($index) && $name = self::getThemeName($index)) {
            self::makeBackup();
            $loc = self::getThemeLocation($name);
            $contents = @file_get_contents($loc);
            $isDark = false;
            if (!$contents) {
                $isDark = true;
                $loc = self::getAltThemeLocation($name);
                $contents = @file_get_contents($loc);
            }
            if ($contents) {
                $bck = self::getBackupLocation($name);

                if ($loc !== $bck) {
                    @file_put_contents($bck, $contents) && @chmod($bck, 0777);
                }
                // update mtime
                @touch($bck);

                $contents = self::setCommentParam("themeName", $name) . $contents;
                $cssFile = $isDark ? self::THEME_FILE_DARK : self::THEME_FILE;
                $mask = @umask(0);
                try {
                    if (@file_put_contents($file = self::getAdminerLocation() . DIRECTORY_SEPARATOR . $cssFile, $contents)) {
                        @chmod($file, 0777);
                        self::$selectedDark = $isDark;
                        return true;
                    }
                } finally {
                    @umask($mask);
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
        $files = [
            self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE,
            self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE_DARK
        ];
        $ok = [];
        foreach ($files as $file) {
            @unlink($file);
            $ok[] = !is_file($file);
        }

        return !in_array(false, $ok, true);
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
            self::$selectedDark = false;
            $locations = [
                self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE,
                self::getAdminerLocation() . DIRECTORY_SEPARATOR . self::THEME_FILE_DARK
            ];


            foreach ($locations as $location) {
                if (is_file($orig = $location)) {

                    $isDark = basename($orig) == self::THEME_FILE_DARK;

                    $contents = @file_get_contents($orig);

                    if ($current = self::getCommentParam($contents, "themeName")) {
                        $index = array_search($current, self::getThemeList());
                        if (is_int($index)) {
                            self::$selectedDark = $isDark;
                            self::$theme = "$index";
                            return self::$theme;
                        }
                    }

                    $crc = crc32($contents);

                    foreach (self::getThemeList() as $index => $name) {
                        if (is_file($path = self::getBackupLocation($name))) {
                            if ($crc === crc32(@file_get_contents($path) ?: '')) {
                                self::$theme = "$index";
                                self::$selectedDark = $isDark;
                                break;
                            }
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
