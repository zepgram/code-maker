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

use Zepgram\CodeMaker\File\Management;
use Zepgram\CodeMaker\Maker;

abstract class Operations
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
     * @var array
     */
    protected $filesInjection;

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
                Management::writeFiles($this->getAbsoluteFilePath($path), $content);
            }
        }
        if ($this->filesAppend) {
            foreach ($this->filesAppend as $path => $content) {
                $asChange = Management::appendXmlFiles($this->getAbsoluteFilePath($path), $content);
                if (!$asChange) {
                    unset($this->filesAppend[$path]);
                }
            }
        }
        if ($this->filesInjection) {
            foreach ($this->filesInjection as $path => $content) {
                Management::writeFiles($this->getAbsoluteFilePath($path), $content);
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
     * @return array
     */
    public function getInjectionOperation()
    {
        return $this->filesInjection;
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
     * @param $filePath
     * @param $content
     */
    public function addInjectionOperation($filePath, $content)
    {
        $this->filesInjection[$filePath] = $content;
    }

    /**
     * @param $path
     *
     * @return string
     */
    public function getAbsoluteFilePath($path)
    {
        return $this->maker->getModuleDirectory().DIRECTORY_SEPARATOR.$path;
    }

    /**
     * Build statements
     */
    abstract protected function setFilesStatements();
}