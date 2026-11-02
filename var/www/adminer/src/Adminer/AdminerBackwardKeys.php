<?php

namespace Adminer;

/** Display links to tables referencing current row, same as in Adminer Editor.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerBackwardKeys extends Plugin
{
    protected $translations = [
        'cs' => [
            ''         => 'Zobrazí odkazy na tabulky odkazující na aktuální řádek, stejně jako Adminer Editor',
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
            ''         => 'Wyświetlaj linki do tabel odnoszących się do bieżącego wiersza, tak samo jak w Adminer Editorze',
            'New item' => 'Nowy rekord',
        ],
        'hr' => [
            ''         => 'Prikazuje veze na tablice koje referenciraju trenutni redak, kao u Adminer Editoru',
            'New item' => 'Nova stavka',
        ],
        'ro' => [
            '' => 'Afișează link-uri către tabelele care fac referire la rândul curent, la fel ca în Adminer Editor',
        ],
        'sk' => [
            '' => 'Zobrazí odkazy na tabuľky odkazujúce na aktuálny riadok, rovnako ako Adminer Editor',
        ],
        'zh' => [
            ''         => '显示引用当前行的表的链接，与 Adminer Editor 中相同',
            'New item' => '新建数据',
        ],
    ];

    // this is copy-pasted from Adminer Editor

    public function backwardKeys($table, $tableName)
    {
        $return = [];

        if ('pgsql' == JUSH) // information_schema is very slow in PostgreSQL with many tables
        {$query = "SELECT n.nspname AS ns, r.relname AS table_name, c.conname AS constraint_name, a.attname AS column_name, t.attname AS referenced_column_name
FROM (
	SELECT conrelid, confrelid, conname, conkey, confkey, generate_subscripts(conkey, 1) AS i
	FROM pg_constraint
	WHERE contype = 'f' AND confrelid = " . driver()->tableOid($table) . '
) c
JOIN pg_class r ON r.oid = c.conrelid
JOIN pg_namespace n ON n.oid = r.relnamespace
JOIN pg_attribute a ON a.attrelid = c.conrelid AND a.attnum = c.conkey[c.i]
JOIN pg_attribute t ON t.attrelid = c.confrelid AND t.attnum = c.confkey[c.i]
ORDER BY n.nspname, r.relname, c.conname, c.i';
        } else
        {
            // we couldn't use the same query in MySQL and MS SQL because unique_constraint_name is not table-specific in MySQL and referenced_table_name is not available in MS SQL
            $query = 'SELECT s.table_name table_name, s.constraint_name constraint_name, s.column_name column_name,
	' . ('sql' == JUSH ? 'referenced_column_name' : 't.column_name') . ' referenced_column_name, s.table_schema ' . ('sql' == JUSH ? 'db' : 'ns') . '
FROM information_schema.key_column_usage s' . ('sql' == JUSH ? '
WHERE referenced_table_schema = ' . q(DB) . '
AND referenced_table_name' : '
JOIN information_schema.referential_constraints r USING (constraint_catalog, constraint_schema, constraint_name)
JOIN information_schema.key_column_usage t ON r.unique_constraint_catalog = t.constraint_catalog
	AND r.unique_constraint_schema = t.constraint_schema
	AND r.unique_constraint_name = t.constraint_name
	AND r.constraint_catalog = t.constraint_catalog
	AND r.unique_constraint_name = t.constraint_name
	AND s.position_in_unique_constraint = t.ordinal_position
WHERE t.table_catalog = ' . q(DB) . ' AND t.table_schema = ' . q("{$_GET['ns']}") . '
AND t.table_name') . ' = ' . q($table) . '
ORDER BY
	s.table_schema,
	s.table_name,
	s.constraint_name,
	s.ordinal_position';
        }

        foreach (get_rows($query, null, '') as $row)
        {
            $db                                                                 = ('' != idx($row, 'db') && DB != $row['db'] ? $row['db'] : ''); // db is selected only in MySQL
            $ns                                                                 = (idx($row, 'ns') != $_GET['ns'] ? idx($row, 'ns') : ''); // ns is not selected in MySQL
            $key                                                                = idf_escape($db) . '.' . idf_escape($ns) . '.' . idf_escape($row['table_name']); // the same table name can be in several databases or schemas

            $return[$key]['table']                                              = $row['table_name'];
            $return[$key]['db']                                                 = $db;
            $return[$key]['ns']                                                 = $ns;
            $return[$key]['keys'][$row['constraint_name']][$row['column_name']] = $row['referenced_column_name'];
        }

        foreach ($return as $key => $val)
        {
            // table_status1() looks only in the current database and schema
            $name = adminer()->tableName('' != $val['db'] || '' != $val['ns'] ? ['Name' => $val['table']] : table_status1($val['table'], true));

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

    /** Custom local print: [+] name | [+] name … */
    public function backwardKeysPrint($backwardKeys, $row)
    {
        $buffer = [];

        foreach ($backwardKeys as $backwardKey)
        {
            if ( ! is_array($backwardKey) || ! isset($backwardKey['keys']) || ! is_iterable($backwardKey['keys']))
            {
                continue;
            }
            $table = $backwardKey['table'];
            $db    = $backwardKey['db'];
            $ns    = $backwardKey['ns'];
            $me    = ('' != $db ? preg_replace('~&db=[^&]*~', '&db=' . url_escape($db), ME) : ME);

            if ('' != $ns)
            {
                $me = preg_replace('~&ns=[^&]*~', '&ns=' . url_escape($ns), $me);
            }

            foreach ($backwardKey['keys'] as $cols)
            {
                $link     = $me . 'select=' . url_escape($table);
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
                $l        = "<a href='" . h($link) . "'>" . h($name) . '</a>';
                $link     = $me . 'edit=' . url_escape($table);

                foreach ($cols as $column => $val)
                {
                    $link .= '&set[' . url_escape(bracket_escape($column)) . ']=' . url_escape($row[$val]);
                }

                $buffer[] = "<a href='" . h($link) . "' title='" . $this->lang('New item') . "'>[+]</a> {$l}";
            }
        }

        echo implode(' | ', $buffer);
    }

    public function screenshot()
    {
        return 'https://www.adminer.org/static/plugins/backward-keys.webp';
    }
}
