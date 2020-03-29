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
     * @param string $value
     * @param bool   $upper
     *
     * @return string|string[]|null
     */
    public static function asSnakeCase(string $value, $upper = false)
    {
        $value = self::caseFormatter('_', $value);
        $value = self::lowercase($value);
        if ($upper) {
            $value = strtoupper($value);
        }

        return $value;
    }

    /**
     * @param string $value
     * @param bool   $upper
     *
     * @return string
     */
    public static function asKebabCase(string $value, $upper = false)
    {
        $value = self::caseFormatter('-', $value);
        $value = self::lowercase($value);
        if ($upper) {
            $value = strtoupper($value);
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return string|string[]|null
     */
    public static function asUpperSnakeCase(string $value)
    {
        return self::asSnakeCase($value, true);
    }

    /**
     * @param string $value
     *
     * @return string|string[]|null
     */
    public static function asUpperKebabCase(string $value)
    {
        return self::asKebabCase($value, true);
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function asCamelCase(string $str)
    {
        $str = strtr(self::ucwords(strtr($str, ['_' => ' ', '.' => ' ', '\\' => ' '])), [' ' => '']);
        $str[0] = strtolower($str[0]);

        return $str;
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function asPascaleCase(string $str)
    {
        $str[0] = strtoupper($str[0]);

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

    /**
     * @param string $stringCard
     * @param string $value
     *
     * @return string|string[]|null
     */
    private static function caseFormatter(string $stringCard, string $value)
    {
        $value = trim($value);
        $value = preg_replace('/[^a-zA-Z0-9' . '_]/', $stringCard, $value);
        $value = preg_replace('/(?<=\\w)([A-Z])/', $stringCard.'$1', $value);
        $value = preg_replace('/_{2,}/', $stringCard, $value);

        return $value;
    }
}
