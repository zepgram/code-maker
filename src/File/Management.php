<?php
/**
 * This file is part of Zepgram\CodeMaker\File
 *
 * @package    Zepgram\CodeMaker
 * @file       Management.php
 * @date       31 08 2019 17:27
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\File;

class Management
{
    /**
     * @param string $templatePath
     * @param array  $parameters
     *
     * @return string
     */
    public static function parseTemplate(string $templatePath, array $parameters): string
    {
        ob_start();
        extract($parameters, EXTR_SKIP);
        include $templatePath;

        return ob_get_clean();
    }

    /**
     * @param $directory
     *
     * @return array
     */
    public static function scanDir($directory)
    {
        return array_diff(scandir($directory), ['..', '.']);
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public static function fileExist($path)
    {
        return file_exists($path);
    }

    /**
     * @param $directory
     *
     * @return bool|void
     */
    public static function mkdir($directory)
    {
        if (is_dir($directory)) {
            return;
        }
        if (@mkdir($directory) || file_exists($directory)) return true;
        return (self::mkdir(dirname($directory)) and mkdir($directory));
    }


    /**
     * @param $filePath
     * @param $content
     *
     * @return bool
     */
    public static function isContentIdentical($filePath, $content)
    {
        return $content === file_get_contents($filePath);
    }

    public static function createFileDirectories($filePath)
    {
        $exploded = explode(DIRECTORY_SEPARATOR, $filePath);
        array_pop($exploded);
        $directoryPathOnly = implode(DIRECTORY_SEPARATOR, $exploded);
        if (!file_exists($directoryPathOnly)) {
            self::mkdir($directoryPathOnly);
        }
    }

    /**
     * @param $filePath
     * @param $content
     */
    public static function writeFiles($filePath, $content)
    {
        self::createFileDirectories($filePath);
        if (strpos(pathinfo($filePath)['extension'], 'xml') !== false) {
            self::saveXml($filePath, $content);
            return;
        }
        file_put_contents($filePath, $content);
    }

    /**
     * @param $filePath
     * @param $content
     */
    public static function appendXmlFiles($filePath, $content)
    {
        $file = new SimpleXmlExtend(file_get_contents($filePath));
        $append = new SimpleXmlExtend($content);
        $file->appendXML($append->children());
        self::saveXml($filePath, $file->asXML());
    }

    /**
     * @param $filePath
     * @param $content
     */
    public static function saveXml($filePath, $content)
    {
        $xml = new \DomDocument('1.0');
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
        $xml->loadXML($content);
        $xml->save($filePath);
    }
}