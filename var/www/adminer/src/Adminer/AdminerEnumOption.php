<?php

namespace Adminer;

class AdminerEnumOption
{

    function editInput($table, $field, $attrs, $value)
    {
        if ($field["type"] == "enum") {
            $options = array();
            $selected = "val-$value";
            if (isset($_GET["select"])) {
                $options["orig"] = lang('original');
                if ($value === null) {
                    $selected = "orig";
                }
            }
            if ($field["null"]) {
                $options["null"] = "NULL";
                if ($value === null) {
                    $selected = "null";
                }
            }
            preg_match_all("~'((?:[^']|'')*)'~", $field["length"], $matches);
            foreach ($matches[1] as $val) {
                $val = stripcslashes(str_replace("''", "'", $val));
                $options["val-$val"] = $val;
            }
            return "<select$attrs>" . optionlist($options, $selected, 1) . "</select>"; // 1 - use keys
        }
    }

    protected $translations = array(
        'cs' => array('' => 'Editace políčka enum pomocí <select><option> místo <input type="radio">'),
        'de' => array('' => 'Verwenden Sie <select><option> für die enum-Bearbeitung anstelle von <input type="radio">'),
        'pl' => array('' => 'Użyj <select><option> do edycji enum zamiast <input type="radio">'),
        'ro' => array('' => 'Utilizați <select><option> pentru editarea enum în loc de <input type="radio">'),
        'ja' => array('' => '列挙型の編集に <input type="radio"> ではなく <select><option> を使用'),
    );
}