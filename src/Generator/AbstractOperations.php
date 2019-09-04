<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       AbstactFiles.php
 * @date       31 08 2019 18:09
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Generator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Zepgram\CodeMaker\FileManager;
use Zepgram\CodeMaker\Maker;

abstract class AbstractOperations
{
    /**
     * @var array
     */
    const APPEND_TEMPLATES = [
        'crontab.xml',
        'events.xml',
        'di.xml',
        'widget.xml',
        'system.xml',
        'config.xml',
    ];

    /**
     * @var array
     */
    protected $filesWrite;

    /**
     * @var array
     */
    protected $filesConfirmation;

    /**
     * @var array
     */
    protected $filesAppend;

    /**
     * @var Maker
     */
    protected $maker;

    /**
     * Write templates
     */
    public function generate()
    {
        if ($this->filesWrite) {
            foreach ($this->filesWrite as $path => $content) {
                FileManager::writeFiles($this->getAbsoluteFilePath($path), $content);
            }
        }
        if ($this->filesAppend) {
            foreach ($this->filesAppend as $path => $content) {
                //@todo: FileManager::appendFiles($this->getAbsoluteFilePath($path), $content);
            }
        }
    }

    /**
     * @return array
     */
    public function getConfirmOperation()
    {
        return $this->filesConfirmation;
    }

    /**
     * @return array
     */
    public function getAppendOperation()
    {
        return $this->filesAppend;
    }

    /**
     * @return array
     */
    public function getWriteOperation()
    {
        return $this->filesWrite;
    }

    /**
     * @param $filePath
     * @param $content
     */
    public function addWriteOperation($filePath, $content)
    {
        $this->filesWrite[$filePath] = $content;
    }

    /**
     * @param $filePath
     * @param $content
     */
    protected function addConfirmOperation($filePath, $content)
    {
        $this->filesConfirmation[$filePath] = $content;
    }

    /**
     * @param $filePath
     * @param $content
     */
    protected function addAppendOperation($filePath, $content)
    {
        $this->filesAppend[$filePath] = $content;
    }

    /**
     * @param $path
     *
     * @return string
     */
    public function getAbsoluteFilePath($path)
    {
        return $this->maker->getAbsolutePath() . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * Build statements
     */
    abstract protected function setFilesStatements();
}