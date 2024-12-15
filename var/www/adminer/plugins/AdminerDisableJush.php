<?php

/**
 * Disables JUSH in textarea.
 * @author David Grudl
 * @license BSD
 */
class AdminerDisableJush
{
    public function head()
    {
?>
        <script<?php echo nonce(); ?> type="text/javascript">
            (function () {
            // theme switcher
            addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('#menu .links').forEach(el => {
            const c = document.createElement('div');
            c.innerHTML = `<a href="./theme-switcher.php">Switch theme</a><a href="./info.php">PHP Infos</a>`
            c.style = `padding: 8px; display:flex; column-gap:8px;justify-content: space-between;`;
            el.parentElement.insertBefore(c, el.parentElement.querySelector('h1').nextElementSibling);
            });
            });
            var origBodyLoad = bodyLoad,
            tags = document.getElementsByTagName('textarea');

            bodyLoad = function (version) {
            for (var i = 0; i < tags.length; i++) {
                tags[i].className=tags[i].className.replace(/\bjush-\S+/, '' );
                }
                return origBodyLoad.apply(window, arguments);
                }
                })();
                </script>
        <?php
    }
}
