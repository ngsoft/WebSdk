<?php

namespace Adminer;

/** Disable version checker.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerVersionNoverify extends Plugin
{
    protected $translations = [
        'cs' => ['' => 'Zakáže kontrolu nových verzí'],
        'de' => ['' => 'Deaktivieren Sie die Versionsprüfung'],
        'hr' => ['' => 'Onemogućuje provjeru novih verzija'],
        'ja' => ['' => 'バージョンチェックを無効化'],
        'pl' => ['' => 'Wyłącz sprawdzanie wersji'],
        'ro' => ['' => 'Dezactivați verificatorul de versiuni'],
        'sk' => ['' => 'Zakáže kontrolu nových verzií'],
        'zh' => ['' => '禁用版本检查'],
    ];

    public function verifyVersion()
    {
        return false;
    }

    /** Adminer < 6.0.0 has no verifyVersion() hook, it only checks the version in JavaScript. */
    public function head($dark = null)
    {
        echo script('verifyVersion = () => { };');
    }
}
