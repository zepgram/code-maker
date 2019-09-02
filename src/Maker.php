<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       Maker.php
 * @date       31 08 2019 15:12
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;


class Maker implements MakerInterface
{
    private $appDirectory;

    private $moduleNamespace;

    private $moduleName;

    private $moduleFullNamespace;

    private $templateSkeleton = [];

    private $templateParameters = [];

    private $filesPath = [];

    public function getAppDirectory()
    {
        return $this->appDirectory;
    }

    public function setAppDirectory($appDirectory)
    {
        $this->appDirectory = $appDirectory;

        return $this;
    }

    public function getModuleNamespace()
    {
        return $this->moduleNamespace;
    }

    public function setModuleNamespace($moduleNamespace)
    {
        $this->moduleNamespace = $moduleNamespace;

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

    public function getModuleFullNamespace()
    {
        return $this->moduleFullNamespace;
    }

    public function setModuleFullNamespace($moduleFullNamespace)
    {
        $this->moduleFullNamespace = $moduleFullNamespace;

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
        if ($this->templateParameters === null) {
            $this->templateParameters = $templatesParameters;

            return $this;
        }
        $this->templateParameters = array_merge($this->templateParameters, $templatesParameters);

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
