<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       Management.php
 * @date       31 08 2019 17:27
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

use Zepgram\CodeMaker\Xml\SimpleXmlExtend;

class FileManager
{
    /**
     * @var string
     */
    const DEVELOPMENT_DIRECTORY = '/app/code';

    /**
     * @var string
     */
    const REGISTRATION_FILE = 'registration.php';

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
        if (@mkdir($directory) || file_exists($directory)) {
            return true;
        }
        return (self::mkdir(dirname($directory)) and mkdir($directory));
    }

    /**
     * @param $filePath
     *
     * @return false|string
     */
    public static function readFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("File $filePath doesn't exist.");
        }

        return file($filePath);
    }

    /**
     * @param $filePath
     *
     * @return bool
     */
    public static function contentFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("File $filePath doesn't exist.");
        }

        return file_get_contents($filePath);
    }

    /**
     * @param $filePath
     */
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
     * @param $xmlOne
     * @param $xmlTwo
     *
     * @return bool
     */
    public static function mergeContentXml($xmlOne, $xmlTwo)
    {
        $file = new SimpleXmlExtend($xmlOne);
        $append = new SimpleXmlExtend($xmlTwo);
        $asChange = $file->appendXML($append->children());
        if ($asChange) {
            return $file->asXML();
        }

        return $asChange;
    }

    /**
     * @param $filePath
     * @param $content
     *
     * @return bool
     */
    public static function appendXmlFiles($filePath, $content)
    {
        $file = new SimpleXmlExtend(file_get_contents($filePath));
        $append = new SimpleXmlExtend($content);
        $asChange = $file->appendXML($append->children());
        if ($asChange) {
            self::saveXml($filePath, $file->asXML());
        }

        return $asChange;
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
