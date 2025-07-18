<?php

namespace Adminer;

/** Display links to tables referencing current row, same as in Adminer Editor
 * @link https://www.adminer.org/plugins/#use
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerBackwardKeys
{
    // this is copy-pasted from Adminer Editor

    function backwardKeys($table, $tableName)
    {
        $return = array();
        foreach (
            get_rows($q = "SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = " . q(DB) . "
AND REFERENCED_TABLE_SCHEMA = " . q(DB) . "
AND REFERENCED_TABLE_NAME = " . q($table) . "
ORDER BY ORDINAL_POSITION", null, "") as $row
        ) {
            $return[$row["TABLE_NAME"]]["keys"][$row["CONSTRAINT_NAME"]][$row["COLUMN_NAME"]] = $row["REFERENCED_COLUMN_NAME"];
        }
        foreach ($return as $key => $val) {
            $name = adminer()->tableName(table_status1($key, true));
            if ($name != "") {
                $search = preg_quote($tableName);
                $separator = '(:|\s*-)?\s+';
                $return[$key]["name"] = (preg_match("(^$search$separator(.+)|^(.+?)$separator$search\$)iu", $name, $match) ? $match[2] . $match[3] : $name);
            } else {
                unset($return[$key]);
            }
        }
        return $return;
    }

    function backwardKeysPrint($backwardKeys, $row)
    {
        $buffer = [];
        foreach ($backwardKeys as $table => $backwardKey) {
            foreach ($backwardKey["keys"] as $cols) {
                $link = ME . 'select=' . urlencode($table);
                $i = 0;
                foreach ($cols as $column => $val) {
                    $link .= where_link($i++, $column, $row[$val]);
                }
                ob_start();
                echo "<a href='" . h($link) . "'>" . h($backwardKey["name"]) . "</a>";
                $l = ob_get_clean();
                $link = ME . 'edit=' . urlencode($table);
                foreach ($cols as $column => $val) {
                    $link .= "&set" . urlencode("[" . bracket_escape($column) . "]") . "=" . urlencode($row[$val]);
                }

                $buffer[] = "<a href='" . h($link) . "' title='" . lang('New item') . "'>[+]</a> $l";

            }
        }

        echo implode(" | ", $buffer);
    }

    function screenshot()
    {
        return "https://www.adminer.org/static/plugins/backward-keys.png";
    }

    protected $translations = array(
        'cs' => array('' => 'Zobrazí odkazy na tabulky odkazující aktuální řádek, stejně jako Adminer Editor'),
        'de' => array('' => 'Links zu Tabellen anzeigen die auf die aktuelle Zeile verweisen, wie im Adminer Editor'),
        'ja' => array('' => 'Adminer Editor と同様に、カレント行を参照しているテーブルへのリンクを表示'),
        'pl' => array('' => 'Wyświetlaj linki do tabel odnoszących się do bieżącego wiersza, tak samo jak w Edytorze administratora'),
    );
}
