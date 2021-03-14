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

use Zepgram\CodeMaker\SimpleXml\Config;
use Zepgram\CodeMaker\SimpleXml\Converter\Dom;
use Zepgram\CodeMaker\SimpleXml\Element;
use Zepgram\CodeMaker\SimpleXml\SimpleXmlExtend;

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
        return (self::mkdir(dirname($directory)) && mkdir($directory));
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
        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'xml') {
            self::saveXml($filePath, $content);
        } else {
            file_put_contents($filePath, self::applyLfOnContent($content));
        }
    }

    /**
     * @param $filePath
     * @param $content
     *
     * @return bool
     */
    public static function appendFiles($filePath, $content)
    {
        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'xml') {
            $asChange = false;
            $file = new SimpleXmlExtend(file_get_contents($filePath));
            $append = new SimpleXmlExtend($content);
            foreach ($append->children() as $child) {
                $asChange = $file->appendXML($child);
            }
            if ($asChange) {
                self::saveXml($filePath, $file->asXML());
            }
            return $asChange;
        } else {
            return file_put_contents($filePath, self::applyLfOnContent(PHP_EOL.$content), FILE_APPEND | LOCK_EX);
        }
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

    /**
     * @param $content
     * @return string|string[]
     */
    private static function applyLfOnContent($content)
    {
        return str_replace("\r\n", PHP_EOL, $content);
    }
}
