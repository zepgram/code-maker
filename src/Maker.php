<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker;

class Maker
{
    /** @var string */
    private $vendorName;

    /** @var string */
    private $moduleName;

    /** @var string */
    private $moduleDirectory;

    /** @var string */
    private $moduleNamespace;

    /** @var bool */
    private $isInitialized;

    /** @var array */
    private $templateSkeleton = [];

    /** @var array */
    private $templateParameters = [];

    /** @var array */
    private $filesPath = [];

    /**
     * Maker constructor.
     *
     * @param string $module
     * @param string $template
     */
    public function __construct(string $module, string $template)
    {
        list($this->vendorName, $this->moduleName) = explode('_', $module);
        Str::ucwords($this->vendorName);
        Str::ucwords($this->moduleName);

        $magentoDirectory = getcwd() . FileManager::DEVELOPMENT_DIRECTORY;
        $moduleDirectory  = "$magentoDirectory/$this->vendorName/$this->moduleName";
        $moduleNamespace  = $this->vendorName . "\\" . $this->moduleName;

        $this->setModuleDirectory($moduleDirectory)
            ->setModuleNamespace($moduleNamespace)
            ->setTemplateSkeleton([$template])
            ->setTemplateParameters([
                'module_name'      => $this->moduleName,
                'module_namespace' => $this->vendorName,
                'lower_namespace'  => Str::lowercase($this->vendorName),
                'lower_module'     => Str::lowercase($this->moduleName),
            ])
            ->setIsInitialized();
    }

    public function getModuleName()
    {
        return $this->vendorName . '_' . $this->moduleName;
    }

    public function getModuleDirectory()
    {
        return $this->moduleDirectory;
    }

    public function setModuleDirectory(string $moduleDirectory)
    {
        $this->moduleDirectory = $moduleDirectory;

        return $this;
    }

    public function getModuleNamespace()
    {
        return $this->moduleNamespace;
    }

    public function setModuleNamespace(string $moduleNamespace)
    {
        $this->moduleNamespace = $moduleNamespace;

        return $this;
    }

    public function getIsInitialized()
    {
        return $this->isInitialized;
    }

    public function setIsInitialized(bool $isInitialized = null)
    {
        $this->isInitialized = file_exists($this->getModuleDirectory().DIRECTORY_SEPARATOR.FileManager::REGISTRATION_FILE);
        if ($isInitialized !== null) {
            $this->isInitialized = $isInitialized;
        }

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
}
