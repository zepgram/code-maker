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

class Templates extends Files
{
    public function __construct(Maker $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return array
     */
    protected function getTemplates()
    {
        $templateDir = $this->generator->getTemplateSkeleton();
        $absolutePathToSkeletons = dirname(__DIR__) . '/Resources/skeleton/' .$templateDir;
        if (!is_dir($absolutePathToSkeletons)) {
            throw new \RuntimeException("Template not found for '$templateDir'");
        }
        $skeletons = FileManager::scanDir($absolutePathToSkeletons);
        $templates = [];

        foreach ($skeletons as $skeleton) {
            $filePath = $this->generator->getFilesPath()[$skeleton];
            if (isset($filePath)) {
                $templates[$filePath] = FileManager::parseTemplate(
                    "$absolutePathToSkeletons/$skeleton",
                    $this->generator->getTemplateParameters()
                );
            }
        }

        return $templates;
    }
}