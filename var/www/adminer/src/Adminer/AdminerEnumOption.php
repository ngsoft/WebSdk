<?php

namespace Adminer;

class AdminerEnumOption
{
    protected $translations = [
        'cs' => ['' => 'Editace políčka enum pomocí <select><option> místo <input type="radio">'],
        'de' => ['' => 'Verwenden Sie <select><option> für die enum-Bearbeitung anstelle von <input type="radio">'],
        'pl' => ['' => 'Użyj <select><option> do edycji enum zamiast <input type="radio">'],
        'ro' => ['' => 'Utilizați <select><option> pentru editarea enum în loc de <input type="radio">'],
        'ja' => ['' => '列挙型の編集に <input type="radio"> ではなく <select><option> を使用'],
    ];

    public function editInput($table, $field, $attrs, $value)
    {
        if ('enum' == $field['type'])
        {
            $options  = [];
            $selected = "val-{$value}";

            if (isset($_GET['select']))
            {
                $options['orig'] = lang('original');

                if (null === $value)
                {
                    $selected = 'orig';
                }
            }

            if ($field['null'])
            {
                $options['null'] = 'NULL';

                if (null === $value)
                {
                    $selected = 'null';
                }
            }
            preg_match_all("~'((?:[^']|'')*)'~", $field['length'], $matches);

            foreach ($matches[1] as $val)
            {
                $val                   = stripcslashes(str_replace("''", "'", $val));
                $options["val-{$val}"] = $val;
            }
            return "<select{$attrs}>" . optionlist($options, $selected, 1) . '</select>'; // 1 - use keys
        }
    }
}
