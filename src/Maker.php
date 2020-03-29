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
use Zepgram\CodeMaker\Generator\Injection;

class Maker
{
    private $moduleDirectory;

    private $moduleNamespace;

    private $isInitialized;

    private $templateSkeleton = [];

    private $templateParameters = [];

    private $filesPath = [];

    private $injection;

    public function __construct($module, $template)
    {
        list($vendorName, $moduleName) = explode('_', $module);
        $vendorName = FormatString::ucwords($vendorName);
        $moduleName = FormatString::ucwords($moduleName);

        $magentoDirectory = getcwd() . Management::DEVELOPMENT_DIRECTORY;
        $moduleDirectory = "$magentoDirectory/$vendorName/$moduleName";
        $moduleNamespace = $vendorName . "\\" . $moduleName;

        $this->setModuleDirectory($moduleDirectory)
            ->setModuleNamespace($moduleNamespace)
            ->setTemplateSkeleton([$template])
            ->setTemplateParameters([
                'module_name'      => $moduleName,
                'module_namespace' => $vendorName,
                'lower_namespace'  => FormatString::lowercase($vendorName),
                'lower_module'     => FormatString::lowercase($moduleName),
            ])
            ->setIsInitialized();
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
