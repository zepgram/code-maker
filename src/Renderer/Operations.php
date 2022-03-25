<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\Renderer;

use Zepgram\CodeMaker\FileManager;
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
        'acl.xml',
        'menu.xml',
        'db_schema.xml',
        'schema.graphqls'
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
                $asChange = FileManager::appendFiles($this->getAbsoluteFilePath($path), $content);
                if (!$asChange) {
                    unset($this->filesAppend[$path]);
                }
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
        return $this->maker->getModuleDirectory().DIRECTORY_SEPARATOR.$path;
    }

    /**
     * Build statements
     */
    abstract protected function setFilesStatements();
}
