<?php

namespace Adminer;

/**
 * Color fields plugin for Adminer.
 *
 * @link https://github.com/smuuf/adminer-colorfields
 * @author Premysl Karbula, http://www.premyslkarbula.cz
 */
class AdminerColorFields
{

    public static $template = '<span style="margin-right: 1ex; vertical-align: middle; display: inline-block; width: 1em; height: 1em; border-radius: 50%%; background-color: %s;"></span>%s';

    public function selectVal(&$val, $link, $field, $original)
    {

        $trimmed = trim($val);

        if (self::isHex($trimmed) || self::isRGBa($trimmed)) {
            $val = sprintf(self::$template, $trimmed, $val);
        }

    }

    private static function isHex($input)
    {
        return preg_match("~^#?([0-9a-fA-F]{3}){1,2}$~", $input);
    }

    private static function isRGBa($input)
    {
        return preg_match("~^rgba?\((\d+),\h*(\d+),\h*(\d+)(,\h*(\d+))?\)$~", $input);
    }

}
