<?php

namespace Adminer;

/**
 * Adds support for Pematon's custom theme.
 * This includes meta-headers, touch icons and other stuff.
 *
 * @link https://github.com/pematon/adminer-theme
 *
 * @author Peter Knut
 * @copyright 2014-2018 Pematon, s.r.o. (http://www.pematon.com/)
 */
class AdminerTheme
{
    const CSS_VERSION = 5;
    const ICONS_VERSION = 3;

    /** @var string */
    private $themeName;


    private $basePath = './static/';
    private $fix;
    private $lang;

    /**
     * Default theme and/or multiple theme names for given hosts can be specified in constructor.
     * File with theme name and .css extension should be located in css folder.
     *
     * @param string $defaultTheme Theme name of default theme.
     */
    public function __construct($defaultTheme = "default-orange", $fix = false, $lang = true)
    {
        define("PMTN_ADMINER_THEME", true);
        AdminerBootstrapSelect::$enabled = false;
        $this->fix = $fix;
        $this->lang = $lang;
        $this->themeName = $defaultTheme;
    }

    /**
     * Prints HTML code inside <head>.
     * @return false
     */
    public function head()
    {

        $userAgent = filter_input(INPUT_SERVER, "HTTP_USER_AGENT");
        $basepath = $this->basePath;
        ?>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>

        <link rel="icon" type="image/ico" href="<?= $basepath ?>images/favicon.png">

        <?php
        // Condition for Windows Phone has to be the first, because IE11 contains also iPhone and Android keywords.
        if (strpos($userAgent, "Windows") !== false):
            ?>
            <meta name="application-name" content="Adminer"/>
            <meta name="msapplication-TileColor" content="#ffffff"/>
            <meta name="msapplication-square150x150logo" content="<?= $basepath ?>images/tileIcon.png"/>
            <meta name="msapplication-wide310x150logo" content="<?= $basepath ?>images/tileIcon-wide.png"/>

        <?php elseif (strpos($userAgent, "iPhone") !== false || strpos($userAgent, "iPad") !== false): ?>
            <link rel="apple-touch-icon-precomposed"
                  href="<?= $basepath ?>images/touchIcon.png?<?php echo self::ICONS_VERSION ?>"/>

        <?php elseif (strpos($userAgent, "Android") !== false): ?>
            <link rel="apple-touch-icon-precomposed"
                  href="<?= $basepath ?>images/touchIcon-android.png?<?php echo self::ICONS_VERSION ?>"/>

        <?php else: ?>
            <link rel="apple-touch-icon" href="<?= $basepath ?>images/touchIcon.png?<?php echo self::ICONS_VERSION ?>"/>
        <?php endif; ?>

        <link rel="stylesheet" type="text/css"
              href="<?= $basepath ?>css/<?php echo htmlspecialchars($this->themeName) ?>.css?<?php echo self::CSS_VERSION ?>">
        <link rel="stylesheet" type="text/css"
              href="<?= $basepath ?>css/custom.css">
        <link rel="stylesheet" <?= nonce() ?> type="text/css" href="<?= asset('fix.css') ?>">
        <script <?= nonce(); ?>>
            (function (document) {
                "use strict";

                <?= json_encode($this->fix)?> && document.documentElement.setAttribute('data-fix', 'true');
                document.documentElement.setAttribute('data-lang', `<?= json_encode($this->lang) ?>`);

                document.addEventListener("DOMContentLoaded", init, false);

                function init() {
                    let menu = document.getElementById("menu"),
                        button = menu.getElementsByTagName("h1")[0];
                    if (!menu || !button) {
                        return;
                    }

                    button.addEventListener("click", function () {
                        if (menu.className.indexOf(" open") >= 0) {
                            menu.className = menu.className.replace(/ *open/, "");
                        } else {
                            menu.className += " open";
                        }
                    }, false);
                }

            })(document);
        </script>

        <?php

        // Return false to disable linking of adminer.css and original favicon.
        // Warning! This will stop executing head() function in all plugins defined after AdminerTheme.
        return false;
    }
}
