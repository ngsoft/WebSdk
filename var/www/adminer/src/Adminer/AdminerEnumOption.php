<?php

namespace Adminer;

/** Use <select><option> for enum edit instead of <input type="radio">.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerEnumOption extends Plugin
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
            ''         => 'enum の編集に <input type="radio"> ではなく <select><option> を使用',
            'original' => '元',
        ],
        'hr' => [
            ''         => 'Koristi <select><option> za uređivanje enum polja umjesto <input type="radio">',
            'original' => 'original',
        ],
        'sk' => [
            '' => 'Použije <select><option> na editáciu enum namiesto <input type="radio">',
        ],
        'zh' => [
            ''         => '编辑 enum 时使用 <select><option> 而不是 <input type="radio">',
            'original' => '原始',
        ],
    ];

    public function editInput($table, $field, $attrs, $value)
    {
        if ('enum' == $field['type'])
        {
            $options  = [];
            // the value is an array when re-printing the form after a failed save, false means the original value
            $selected = (
                is_array($value)
                ? reset($value)
                : (false === $value ? 'orig' : (null === $value ? 'null' : "val-{$value}"))
            );

            if (isset($_GET['select']))
            {
                $options['orig'] = $this->lang('original');
            }

            if ($field['null'])
            {
                $options['null'] = 'NULL';
            }
            preg_match_all("~'(?:[^']|'')*'~", $field['length'], $matches);

            foreach ($matches[0] as $val)
            {
                $val                   = stripcslashes(idf_unescape($val));
                $options["val-{$val}"] = $val;
            }
            return "<select{$attrs}>" . optionlist($options, $selected, 1) . '</select>'; // 1 - use keys
        }
    }
}
