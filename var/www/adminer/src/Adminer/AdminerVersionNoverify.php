<?php

namespace Adminer;

/** Disable version checker.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerVersionNoverify
{
    protected $translations = [
        'cs' => ['' => 'Zakáže kontrolu nových verzí'],
        'de' => ['' => 'Deaktivieren Sie die Versionsprüfung'],
        'pl' => ['' => 'Wyłącz sprawdzanie wersji'],
        'ro' => ['' => 'Dezactivați verificatorul de versiuni'],
        'ja' => ['' => 'バージョンチェックを無効化'],
        'hr' => ['' => 'Onemogućuje provjeru novih verzija'],
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
