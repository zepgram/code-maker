<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       StringFormat.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

class FormatString
{
    /**
     * @param $value
     *
     * @return string|string[]|null
     */
    public static function asSnakeCase($value)
    {
        $value = trim($value);
        $value = preg_replace('/[^a-zA-Z0-9' . '_]/', '_', $value);
        $value = preg_replace('/(?<=\\w)([A-Z])/', '_$1', $value);
        $value = preg_replace('/_{2,}/', '_', $value);
        $value = self::lowercase($value);

        return $value;
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function asCamelCase(string $str)
    {
        return strtr(self::ucwords(strtr($str, ['_' => ' ', '.' => ' ', '\\' => ' '])), [' ' => '']);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function lowercase(string $string)
    {
        return strtolower(trim($string));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function ucwords(string $string)
    {
        return ucwords(trim($string));
    }
}