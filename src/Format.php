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
    public static function asSnakeCase($value)
    {
        $value = trim($value);
        $value = preg_replace('/[^a-zA-Z0-9_]/', '_', $value);
        $value = preg_replace('/(?<=\\w)([A-Z])/', '_$1', $value);
        $value = preg_replace('/_{2,}/', '_', $value);
        $value = strtolower($value);

        return $value;
    }
}