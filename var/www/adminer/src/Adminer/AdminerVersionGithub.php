<?php

namespace Adminer;

/** Verify new versions from GitHub.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerVersionGithub extends Plugin
{
    protected $translations = [
        'cs' => ['' => 'Kontrola nových verzí z GitHubu'],
        'de' => ['' => 'Neue Versionen von GitHub verifizieren'],
        'hr' => ['' => 'Provjera novih verzija s GitHuba'],
        'ja' => ['' => 'GitHub で新しいバージョンを確認'],
        'pl' => ['' => 'Weryfikuj nowe wersje z GitHuba'],
        'ro' => ['' => 'Verifică versiunile noi de pe GitHub'],
        'sk' => ['' => 'Kontrola nových verzií z GitHubu'],
        'zh' => ['' => '在 GitHub 上检查新版本'],
    ];

    public function head($dark = null)
    {
        ?>
        <script <?= nonce(); ?>>
            verifyVersion = () => {
                // dummy value to prevent repeated verifications after AJAX failure
                cookie('adminer_version=0', 1);
                ajax('https://api.github.com/repos/vrana/adminer/releases/latest', request => {
                    const response = JSON.parse(request.responseText);
                    const version = response.tag_name.replace(/^v/, '');
                    // we don't display the version here because we don't have version_compare(); design.inc.php will display it on the next load
                    cookie('adminer_version=' + version, 1);
                }, null, null);
            };
        </script>
        <?php
    }

    public function csp(&$csp)
    {
        $csp[0]['connect-src'] .= ' https://api.github.com/repos/vrana/adminer/releases/latest';
    }
}
