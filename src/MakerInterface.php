<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       MakerInterface.php
 * @date       31 08 2019 15:05
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

interface MakerInterface
{
    public function getModuleNamespace();

    public function setModuleNamespace(string $moduleNamespace);

    public function getTemplateSkeleton();

    public function setTemplateSkeleton(array $templateSkeleton);

    public function getTemplateParameters();

    public function setTemplateParameters(array $templateParameters);

    public function getFilesPath();

    public function setFilesPath(array $filesPath);

    public function getIsInitialized();

    public function setIsInitialized(bool $isInitialized);
}