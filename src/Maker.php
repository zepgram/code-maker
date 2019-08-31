<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       Generator.php
 * @date       31 08 2019 15:12
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;


class Maker implements MakerInterface
{
    private $moduleNamespace;

    private $moduleName;

    private $templateSkeleton;

    private $appDirectory;

    private $templateParameters;

    private $filesPath;

    public function getAppDirectory()
    {
        return $this->appDirectory;
    }

    public function setAppDirectory($appDirectory)
    {
        $this->appDirectory = $appDirectory;

        return $this;
    }

    public function getNamespace()
    {
        return $this->moduleNamespace;
    }

    public function setNamespace($namespace)
    {
        $this->moduleNamespace = $namespace;

        return $this;
    }

    public function getModuleName()
    {
        return $this->moduleName;
    }

    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;

        return $this;
    }

    public function getTemplateSkeleton()
    {
        return $this->templateSkeleton;
    }

    public function setTemplateSkeleton($templateSkeleton)
    {
        $this->templateSkeleton = $templateSkeleton;

        return $this;
    }

    public function getTemplateParameters()
    {
        return $this->templateParameters;
    }

    public function setTemplateParameters(array $templatesParameters)
    {
        $this->templateParameters = $templatesParameters;

        return $this;
    }

    public function getFilesPath()
    {
        return $this->filesPath;
    }

    public function setFilesPath(array $filePath)
    {
        $this->filesPath = $filePath;

        return $this;
    }
}
