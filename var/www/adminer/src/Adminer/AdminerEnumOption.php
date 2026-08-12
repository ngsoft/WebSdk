<?php

namespace Adminer;

/** Use <select><option> for enum edit instead of <input type="radio">.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerEnumOption
{
    protected $translations = [
        'cs' => [
            ''         => 'Editace políčka enum pomocí <select><option> místo <input type="radio">',
            'original' => 'původní',
        ],
        'de' => [
            ''         => 'Verwenden Sie <select><option> für die enum-Bearbeitung anstelle von <input type="radio">',
            'original' => 'Original',
        ],
        'pl' => [
            ''         => 'Użyj <select><option> do edycji enum zamiast <input type="radio">',
            'original' => 'bez zmian',
        ],
        'ro' => [
            ''         => 'Utilizați <select><option> pentru editarea enum în loc de <input type="radio">',
            'original' => 'original',
        ],
        'ja' => [
            ''         => '列挙型の編集に <input type="radio"> ではなく <select><option> を使用',
            'original' => '元',
        ],
        'hr' => [
            ''         => 'Koristi <select><option> za uređivanje enum polja umjesto <input type="radio">',
            'original' => 'original',
        ],
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
