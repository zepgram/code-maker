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
    public function getAppDirectory();

    public function setAppDirectory($appDirectory);

    public function getModuleNamespace();

    public function setModuleNamespace($namespace);

    public function getModuleName();

    public function setModuleName($moduleNamespace);

    public function getModuleFullNamespace();

    public function setModuleFullNamespace($moduleFullNamespace);

    public function getTemplateSkeleton();

    public function setTemplateSkeleton($templateSkeleton);

    public function getTemplateParameters();

    public function setTemplateParameters(array $templateParameters);

    public function getFilesPath();

    public function setFilesPath(array $filesPath);

    public function setIsInitialized(bool $isInitialized);

    public function getIsInitialized();
}