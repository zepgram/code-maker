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

class Templates extends AbstractFiles
{
    public function __construct(Maker $maker)
    {
        $this->maker = $maker;
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
}