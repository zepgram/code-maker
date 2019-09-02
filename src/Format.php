<?php
/**
 * This file is part of Zepgram\CodeMaker for Caudalie
 *
 * @package    Zepgram\CodeMaker
 * @file       Format.php
 * @date       02 09 2019 17:12
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

class Format
{
    /**
     * @param $value
     *
     * @return string|string[]|null
     */
    public static function asSnakeCase($value)
    {
        $value = trim($value);
        $value = preg_replace('/[^a-zA-Z0-9_]/', '_', $value);
        $value = preg_replace('/(?<=\\w)([A-Z])/', '_$1', $value);
        $value = preg_replace('/_{2,}/', '_', $value);
        $value = strtolower($value);

        return $value;
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function asCamelCase(string $str)
    {
        return strtr(ucwords(strtr($str, ['_' => ' ', '.' => ' ', '\\' => ' '])), [' ' => '']);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function lowercase(string $string)
    {
        return strtolower($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function ucwords(string $string)
    {
        return ucwords($string);
    }
}