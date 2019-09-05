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

use Zepgram\CodeMaker\Generator\Injection;

class Maker implements MakerInterface
{
    private $moduleNamespace;

    private $templateSkeleton = [];

    private $templateParameters = [];

    private $filesPath = [];

    private $isInitialized;

    private $injection;

    public function getModuleNamespace()
    {
        return $this->moduleNamespace;
    }

    public function setModuleNamespace(string $moduleNamespace)
    {
        $this->moduleNamespace = $moduleNamespace;

        return $this;
    }

    public function getTemplateSkeleton()
    {
        return $this->templateSkeleton;
    }

    public function setTemplateSkeleton(array $templateSkeleton)
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

    public function getIsInitialized()
    {
        return $this->isInitialized;
    }

    public function setIsInitialized(bool $isInitialized)
    {
        $this->isInitialized = $isInitialized;

        return $this;
    }

    public function getInjection()
    {
        return $this->injection;
    }

    public function setInjection(Injection $injection)
    {
        $this->injection = $injection;

        return $this;
    }
}
