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
     * @param string $string
     * @param bool   $upper
     *
     * @return string|string[]|null
     */
    public static function asSnakeCase(string $string, $upper = false)
    {
        $string = self::caseFormatter('_', $string);
        $string = self::lowercase($string);
        if ($upper) {
            $string = strtoupper($string);
        }

        return $string;
    }

    /**
     * @param string $string
     * @param bool   $upper
     *
     * @return string
     */
    public static function asKebabCase(string $string, $upper = false)
    {
        $string = self::caseFormatter('-', $string);
        $string = self::lowercase($string);
        if ($upper) {
            $string = strtoupper($string);
        }

        return $string;
    }

    /**
     * @param string $string
     *
     * @return string|string[]|null
     */
    public static function asUpperSnakeCase(string $string)
    {
        return self::asSnakeCase($string, true);
    }

    /**
     * @param string $string
     *
     * @return string|string[]|null
     */
    public static function asUpperKebabCase(string $string)
    {
        return self::asKebabCase($string, true);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function asCamelCase(string $string)
    {
        $string    = strtr(self::ucwords(strtr($string, ['_' => ' ', '.' => ' ', '\\' => ' '])), [' ' => '']);
        $string[0] = strtolower($string[0]);

        return $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function asCamelCaseNoSlash(string $string)
    {
        $string = self::sanitizeNeedle($string, '/');

        return self::asCamelCase($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function asPascaleCase(string $string)
    {
        $string[0] = strtoupper($string[0]);

        return strtr(self::ucwords(strtr($string, ['_' => ' ', '.' => ' ', '\\' => ' '])), [' ' => '']);
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
     * @param string $string
     *
     * @param string $needle
     *
     * @return string
     */
    public static function sanitizeNeedle(string $string, string $needle)
    {
        return str_replace($needle, '', $string);
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
