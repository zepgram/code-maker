<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       Files.php
 * @date       31 08 2019 18:09
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Generator;


use Zepgram\CodeMaker\FileManager;
use Zepgram\CodeMaker\Maker;

abstract class Files
{
    /** @var Maker */
    protected $generator;

    public function writeTemplates()
    {
        $appDirectory = $this->generator->getAppDirectory();
        $namespaceDirectory = $appDirectory.$this->generator->getNamespace().DIRECTORY_SEPARATOR;
        $moduleDirectory = $namespaceDirectory.$this->generator->getModuleName().DIRECTORY_SEPARATOR;

        FileManager::mkdir($appDirectory);
        FileManager::mkdir($namespaceDirectory);
        FileManager::mkdir($moduleDirectory);

        foreach ($this->getTemplates() as $path => $content) {
            FileManager::writeFiles($moduleDirectory . $path, $content);
        }
    }

    abstract protected function getTemplates();
}