<?php

namespace Adminer;

/** Select a foreign key in an edit form.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerEditForeign extends Plugin
{
    protected $limit;
    protected $display;

    protected $translations = [
        'cs' => [
            ''                          => 'Výběr cizího klíče v editačním formuláři',
            'Foreign keys in edit form' => 'Cizí klíče v editačním formuláři',
            'Description'               => 'Popis',
            'ID (description)'          => 'ID (popis)',
            'Description (ID)'          => 'Popis (ID)',
        ],
        'de' => [
            ''                          => 'Wählen Sie im Bearbeitungsformular den Fremdschlüssel aus',
            'Foreign keys in edit form' => 'Fremdschlüssel im Bearbeitungsformular',
            'Description'               => 'Beschreibung',
            'ID (description)'          => 'ID (Beschreibung)',
            'Description (ID)'          => 'Beschreibung (ID)',
        ],
        'hr' => [
            ''                          => 'Odabir stranog ključa u obrascu za uređivanje',
            'Foreign keys in edit form' => 'Strani ključevi u obrascu za uređivanje',
            'Description'               => 'Opis',
            'ID (description)'          => 'ID (opis)',
            'Description (ID)'          => 'Opis (ID)',
        ],
        'ja' => [
            ''                          => '外部キーを編集フォームで選択',
            'Foreign keys in edit form' => '編集フォームの外部キー',
            'Description'               => '説明',
            'ID (description)'          => 'ID (説明)',
            'Description (ID)'          => '説明 (ID)',
        ],
        'pl' => [
            ''                          => 'Wybierz klucz obcy w formularzu edycji',
            'Foreign keys in edit form' => 'Klucze obce w formularzu edycji',
            'Description'               => 'Opis',
            'ID (description)'          => 'ID (opis)',
            'Description (ID)'          => 'Opis (ID)',
        ],
        'ro' => [
            ''                          => 'Selectați cheia străină în formularul de editare',
            'Foreign keys in edit form' => 'Chei externe în formularul de editare',
            'Description'               => 'Descriere',
            'ID (description)'          => 'ID (descriere)',
            'Description (ID)'          => 'Descriere (ID)',
        ],
        'sk' => [
            ''                          => 'Výber cudzieho kľúča v editačnom formulári',
            'Foreign keys in edit form' => 'Cudzie kľúče v editačnom formulári',
            'Description'               => 'Popis',
            'ID (description)'          => 'ID (popis)',
            'Description (ID)'          => 'Popis (ID)',
        ],
        'zh' => [
            ''                          => '在编辑表单中选择外键',
            'Foreign keys in edit form' => '编辑表单中的外键',
            'Description'               => '描述',
            'ID (description)'          => 'ID（描述）',
            'Description (ID)'          => '描述（ID）',
        ],
    ];

    /**
     * @param int            $limit   maximum number of rows in <select>, more rows are searched by AJAX in <datalist>, 0 means unlimited
     * @param ''|'both'|'id' $display see config() for explanation
     */
    public function __construct($limit = 0, $display = '')
    {
        $this->limit   = $limit;
        $this->display = $display;
    }

    public function config()
    {
        $options = [
            ''     => $this->lang('Description'),
            'id'   => $this->lang('ID (description)'),
            'both' => $this->lang('Description (ID)'),
        ];
        $display = get_setting('edit_foreign', 'adminer_config', $this->display);

        return [$this->lang('Foreign keys in edit form') => html_radios('config[edit_foreign]', $options, $display, '<br>')];
    }

    public function afterConnect()
    {
        if (isset($_GET['edit-foreign']))
        {
            $fields = fields($_GET['edit-foreign']);
            $field  = $fields[$_GET['field']];

            if ($field && (list($target, $id, $name) = $this->foreignColumn($_GET['edit-foreign'], $field)) && $name != $id)
            {
                $value = $_GET['value'];
                $exact = (preg_match('~^[0-9]+$~', $value) ? "{$id} = " . q($value) : '');
                $where = ($exact ? "{$exact} OR " : '') . "{$name} LIKE " . q("{$value}%");
                // the row with the typed ID first, the limit would cut it off otherwise; CASE - MS SQL and Oracle can't order by ($exact) DESC
                $order = ($exact ? "CASE WHEN {$exact} THEN 0 ELSE 1 END, " : '') . '2';
                echo optionlist($this->options('SELECT' . limit("{$id}, {$name} FROM {$target}", " WHERE {$where} ORDER BY {$order}", $this->limit)), null, true);
            }

            exit;
        }
    }

    public function editInput($table, $field, $attrs, $value)
    {
        static $values = [];
        static $lists  = 0;

        if (list($target, $id, $name) = $this->foreignColumn($table, $field))
        {
            $options = &$values[$target][$id];

            if (null === $options)
            {
                // no ORDER BY - a big table stops after the limit instead of sorting all rows
                $display = get_setting('edit_foreign', 'adminer_config', $this->display);
                $options = $this->options('SELECT' . limit("{$id}, {$name} FROM {$target}", '', $this->limit ? $this->limit + 1 : 0), $display);

                if ($this->limit && count($options) > $this->limit)
                {
                    $options = false;
                } else
                {
                    asort($options, SORT_NATURAL); // natural - "ID (description)" by the number
                    $options = ['' => ''] + $options;
                }
            }

            if ($options)
            {
                return "<select{$attrs}>" . optionlist($options, $value, true) . '</select>';
            }

            if ($name != $id) // a datalist of bare IDs would add nothing to the default input
            {++$lists;
                return "<input value='" . h($value) . "' list='edit-foreign-{$lists}'"
                    . on('input', 'editForeignInput', ME . 'edit-foreign=' . url_escape($table) . '&field=' . url_escape($field['field']) . '&value=')
                    . "{$attrs}><datalist id='edit-foreign-{$lists}'></datalist>"
                    . ($lists > 1 ? '' : script('function editForeignInput(url) {
	const input = this;
	const value = input.value;
	ajax(url + urlEscape(value), request => {
		if (input.value == value) { // ignore old responses
			input.list.innerHTML = request.responseText;
		}
	});
}'));
            }
        }
    }

    /** Get the referenced table, the referenced column and the first string column describing its row.
     * @param mixed $table
     *
     * @return array{string, string, string}|void the referenced column also in place of a missing description
     */
    protected function foreignColumn($table, array $field)
    {
        static $foreignTables = [];
        $foreignKeys          = &$foreignTables[$table];

        if (null === $foreignKeys)
        {
            $foreignKeys = column_foreign_keys($table);
        }

        foreach ((array) idx($foreignKeys, $field['field']) as $foreignKey)
        {
            if (1 == count($foreignKey['source']))
            {
                $otherDb = ('' != idx($foreignKey, 'db') && DB != $foreignKey['db']); // Oracle fills the current owner
                $target  = ($otherDb ? idf_escape($foreignKey['db']) . '.' : '')
                    . ('' != idx($foreignKey, 'ns') ? idf_escape($foreignKey['ns']) . '.' : '')
                    . idf_escape($foreignKey['table']);
                $id      = idf_escape($foreignKey['target'][0]);

                if (preg_match('~binary~', $field['type']))
                {
                    $id = "HEX({$id})";
                }
                $name    = $id;

                // fields() works in the current database and schema, Oracle's in the current owner
                if ( ! $otherDb || ('sql' == JUSH && connection()->select_db($foreignKey['db'])))
                {
                    $schema      = $_GET['ns'];
                    $otherSchema = ('' != idx($foreignKey, 'ns') && $foreignKey['ns'] != $schema);

                    if ($otherSchema)
                    {
                        set_schema($foreignKey['ns']);
                    }

                    foreach (fields($foreignKey['table']) as $column)
                    {
                        if (preg_match('~char|text~', $column['type']))
                        {
                            if ($column['field'] != $foreignKey['target'][0])
                            {
                                $name = idf_escape($column['field']);
                            }
                            break;
                        }
                    }

                    if ($otherSchema)
                    {
                        set_schema($schema);
                    }

                    if ($otherDb)
                    {
                        connection()->select_db(DB);
                    }
                }
                return [$target, $id, $name];
            }
        }
    }

    /** Get options from a query selecting an ID and its description.
     * @param ''|'both'|'id' $display not used in <datalist> which shows also the ID
     * @param mixed          $query
     *
     * @return string[] the ID in place of a NULL description
     */
    protected function options($query, $display = '')
    {
        $return = [];

        foreach (get_key_vals($query) as $id => $name)
        {
            $return[$id] = (null === $name || "{$name}" === "{$id}" ? $id // the same also without a description column
                : ('id' == $display ? "[{$id}] {$name}"
                    : (
                        'both' == $display ? "{$name} [{$id}]"
                        : $name
                    )));
        }
        return $return;
    }
}
