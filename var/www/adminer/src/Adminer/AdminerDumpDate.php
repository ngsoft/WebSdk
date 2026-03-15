<?php

namespace Adminer;

/** Include current date and time in export filename.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDumpDate
{
    protected $translations = [
        'cs' => ['' => 'Do názvu souboru s exportem přidá aktuální datum a čas'],
        'de' => ['' => 'Aktuelles Datum und die aktuelle Uhrzeit in den Namen der Exportdatei einfügen'],
        'pl' => ['' => 'Dołącz bieżącą datę i godzinę do nazwy pliku eksportu'],
        'ro' => ['' => 'Includeți data și ora curentă în numele fișierului de export'],
        'ja' => ['' => 'エクスポートファイル名に現在日時を含める'],
    ];

    public function dumpFilename($identifier)
    {
        return friendly_url(('' != $identifier ? $identifier : (SERVER ?: 'localhost')) . '-' . get_val('SELECT NOW()'));
    }
}
