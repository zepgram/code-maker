<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       Templates.php
 * @date       31 08 2019 16:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Renderer;

use Zepgram\CodeMaker\Maker;
use Zepgram\CodeMaker\FileManager;

class Templates extends Operations
{
    /**
     * Templates constructor.
     *
     * @param Maker $maker
     */
    public function __construct(Maker $maker)
    {
        $this->maker = $maker;
        $this->writeAppDirectories();
        $this->setFilesStatements();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFilesStatements()
    {
        foreach ($this->getTemplates() as $path => $content) {
            $filePath = $this->getAbsoluteFilePath($path);
            // must be append
            if (FileManager::fileExist($filePath) && in_array(basename($filePath), self::APPEND_TEMPLATES, true)) {
                $this->addAppendOperation($path, $content);
                continue;
            }
            // must be confirmed
            if (FileManager::fileExist($filePath)) {
                $this->addConfirmOperation($path, $content);
                continue;
            }
            $this->addWriteOperation($path, $content);
        }
    }

    /**
     * Write app directories
     */
    private function writeAppDirectories()
    {
        FileManager::mkdir($this->maker->getModuleDirectory());

        if (!$this->maker->getIsInitialized()) {
            $this->maker->setTemplateSkeleton(array_merge($this->maker->getTemplateSkeleton(), ['module']))
                ->setFilesPath(array_merge([
                    'module.tpl.php'       => 'etc/module.xml',
                    'registration.tpl.php' => 'registration.php',
                    'composer.tpl.php'     => 'composer.json'
                ], $this->maker->getFilesPath()));
        }
    }

    /**
     * @return array
     */
    private function getTemplates()
    {
        $templates = [];
        $templateDirectories = $this->maker->getTemplateSkeleton();
        foreach ($templateDirectories as $templateDirectory) {
            $absolutePathToSkeletons = dirname(__DIR__) . '/Resources/skeleton/'.$templateDirectory;
            if (!is_dir($absolutePathToSkeletons)) {
                throw new \RuntimeException("Template not found for '$templateDirectory'");
            }

            $skeletons = FileManager::scanDir($absolutePathToSkeletons);
            foreach ($skeletons as $skeleton) {
                $filePath = $this->maker->getFilesPath();
                if (isset($filePath[$skeleton])) {
                    $fileName = $filePath[$skeleton];
                    $templateContent = FileManager::parseTemplate(
                        "$absolutePathToSkeletons/$skeleton",
                        $this->maker->getTemplateParameters()
                    );
                    $templates[$fileName] = $templateContent;
                }
            }
        }

        return $templates;
    }
}
