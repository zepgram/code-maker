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

use Zepgram\CodeMaker\File\Management;

class Maker
{
    private $vendorName;

    private $moduleName;

    private $moduleDirectory;

    private $moduleNamespace;

    private $isInitialized;

    private $templateSkeleton = [];

    private $templateParameters = [];

    private $filesPath = [];

    public function __construct($module, $template)
    {
        list($this->vendorName, $this->moduleName) = explode('_', $module);
        FormatString::ucwords($this->vendorName);
        FormatString::ucwords($this->moduleName);

        $magentoDirectory = getcwd() . Management::DEVELOPMENT_DIRECTORY;
        $moduleDirectory  = "$magentoDirectory/$this->vendorName/$this->moduleName";
        $moduleNamespace  = $this->vendorName . "\\" . $this->moduleName;

        $this->setModuleDirectory($moduleDirectory)
            ->setModuleNamespace($moduleNamespace)
            ->setTemplateSkeleton([$template])
            ->setTemplateParameters([
                'module_name'      => $this->moduleName,
                'module_namespace' => $this->vendorName,
                'lower_namespace'  => FormatString::lowercase($this->vendorName),
                'lower_module'     => FormatString::lowercase($this->moduleName),
            ])
            ->setIsInitialized();
    }

    public function getModuleName()
    {
        return $this->vendorName . $this->moduleName;
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
        $this->isInitialized = file_exists($this->getModuleDirectory().DIRECTORY_SEPARATOR.Management::REGISTRATION_FILE);
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
