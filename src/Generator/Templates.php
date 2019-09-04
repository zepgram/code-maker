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

namespace Zepgram\CodeMaker\Generator;

use Zepgram\CodeMaker\Maker;
use Zepgram\CodeMaker\FileManager;

class Templates extends AbstractOperations
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
     * Write app directories
     */
    public function writeAppDirectories()
    {
        FileManager::mkdir($this->maker->getAbsolutePath());

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
    protected function getTemplates()
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
                    $templates[$filePath[$skeleton]] = FileManager::parseTemplate(
                        "$absolutePathToSkeletons/$skeleton",
                        $this->maker->getTemplateParameters()
                    );
                }
            }
        }

        return $templates;
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
}