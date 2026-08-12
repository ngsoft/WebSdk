<?php

namespace Adminer;

/** Display links to tables referencing current row, same as in Adminer Editor.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerBackwardKeys
{
    protected $translations = [
        'cs' => [
            ''         => 'Zobrazí odkazy na tabulky odkazující aktuální řádek, stejně jako Adminer Editor',
            'New item' => 'Nová položka',
        ],
        'de' => [
            ''         => 'Links zu Tabellen anzeigen die auf die aktuelle Zeile verweisen, wie im Adminer Editor',
            'New item' => 'Neuer Datensatz',
        ],
        'ja' => [
            ''         => 'Adminer Editor と同様に、カレント行を参照しているテーブルへのリンクを表示',
            'New item' => '新規レコードを挿入',
        ],
        'pl' => [
            ''         => 'Wyświetlaj linki do tabel odnoszących się do bieżącego wiersza, tak samo jak w Edytorze administratora',
            'New item' => 'Nowy rekord',
        ],
        'hr' => [
            ''         => 'Prikazuje veze na tablice koje referenciraju trenutni redak, kao u Adminer Editoru',
            'New item' => 'Nova stavka',
        ],
    ];

    // this is copy-pasted from Adminer Editor

    public function backwardKeys($table, $tableName)
    {
        $return = [];

        // we couldn't use the same query in MySQL and PostgreSQL because unique_constraint_name is not table-specific in MySQL and referenced_table_name is not available in PostgreSQL
        foreach (
            get_rows('SELECT s.table_name table_name, s.constraint_name constraint_name, s.column_name column_name,
	' . ('sql' == JUSH ? 'referenced_column_name' : 't.column_name') . ' referenced_column_name
FROM information_schema.key_column_usage s' . ('sql' == JUSH ? '
WHERE table_schema = ' . q(DB) . '
AND referenced_table_schema = ' . q(DB) . '
AND referenced_table_name' : '
JOIN information_schema.referential_constraints r USING (constraint_catalog, constraint_schema, constraint_name)
JOIN information_schema.key_column_usage t ON r.unique_constraint_catalog = t.constraint_catalog
	AND r.unique_constraint_schema = t.constraint_schema
	AND r.unique_constraint_name = t.constraint_name
	AND r.constraint_catalog = t.constraint_catalog
	AND r.constraint_schema = t.constraint_schema
	AND r.unique_constraint_name = t.constraint_name
	AND s.position_in_unique_constraint = t.ordinal_position
WHERE t.table_catalog = ' . q(DB) . ' AND t.table_schema = ' . q("{$_GET['ns']}") . '
AND t.table_name') . ' = ' . q($table) . '
ORDER BY s.ordinal_position', null, '') as $row
        ) {
            $return[$row['table_name']]['keys'][$row['constraint_name']][$row['column_name']] = $row['referenced_column_name'];
        }

        foreach ($return as $key => $val)
        {
            $name = adminer()->tableName(table_status1($key, true));

            if ('' != $name)
            {
                $search               = preg_quote($tableName);
                $separator            = '(:|\s*-)?\s+';
                $return[$key]['name'] = (preg_match("(^{$search}{$separator}(.+)|^(.+?){$separator}{$search}\$)iu", $name, $match) ? $match[2] . $match[3] : $name);
            } else
            {
                unset($return[$key]);
            }
        }
        return $return;
    }

    public function backwardKeysPrint($backwardKeys, $row)
    {
        $buffer = [];

        foreach ($backwardKeys as $table => $backwardKey)
        {
            foreach ($backwardKey['keys'] as $cols)
            {
                $link     = ME . 'select=' . urlencode($table);
                $i        = 0;

                foreach ($cols as $column => $val)
                {
                    if ( ! isset($row[$val]))
                    {
                        continue 2;
                    }
                    $link .= where_link($i++, $column, $row[$val]);
                }
                $name     = $backwardKey['name'];
                // $name = preg_replace('(^' . preg_quote($_GET['select']) . ('s' == substr($_GET['select'], -1) ? '?' : '') . '_)', '', $backwardKey['name']);
                ob_start();
                echo "<a href='" . h($link) . "'>" . h($name) . '</a>';
                $l        = ob_get_clean();
                $link     = ME . 'edit=' . urlencode($table);

                foreach ($cols as $column => $val)
                {
                    $link .= '&set' . urlencode('[' . bracket_escape($column) . ']') . '=' . urlencode($row[$val]);
                }

                $buffer[] = "<a href='" . h($link) . "' title='" . lang('New item') . "'>[+]</a> {$l}";
            }
        }

        echo implode(' | ', $buffer);
    }

    public function screenshot()
    {
        return 'https://www.adminer.org/static/plugins/backward-keys.png';
    }
}
