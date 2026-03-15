<?php

namespace Adminer;

/** Select a foreign key in an edit form.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerEditForeign
{
    protected $limit;

    protected $translations = [
        'cs' => ['' => 'Výběr cizího klíče v editačním formuláři'],
        'de' => ['' => 'Wählen Sie im Bearbeitungsformular den Fremdschlüssel aus'],
        'pl' => ['' => 'Wybierz klucz obcy w formularzu edycji'],
        'ro' => ['' => 'Selectați cheia străină în formularul de editare'],
        'ja' => ['' => '外部キーを編集フォームで選択'],
    ];

    public function __construct($limit = 0)
    {
        $this->limit = $limit;
    }

    public function editInput($table, $field, $attrs, $value)
    {
        static $foreignTables = [];
        static $values        = [];
        $foreignKeys          = &$foreignTables[$table];

        if (null === $foreignKeys)
        {
            $foreignKeys = column_foreign_keys($table);
        }

        foreach ((array) $foreignKeys[$field['field']] as $foreignKey)
        {
            if (1 == count($foreignKey['source']))
            {
                $target  = $foreignKey['table'];
                $id      = $foreignKey['target'][0];
                $options = &$values[$target][$id];

                if ( ! $options)
                {
                    $column  = idf_escape($id);

                    if (preg_match('~binary~', $field['type']))
                    {
                        $column = "HEX({$column})";
                    }
                    $options = ['' => ''] + get_vals("SELECT {$column} FROM " . table($target) . ' ORDER BY 1' . ($this->limit ? ' LIMIT ' . ($this->limit + 1) : ''));

                    if ($this->limit && count($options) - 1 > $this->limit)
                    {
                        return;
                    }
                }
                return "<select{$attrs}>" . optionlist($options, $value) . '</select>';
            }
        }
    }
}
