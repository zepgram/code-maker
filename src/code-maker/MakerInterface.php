<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       Generator.php
 * @date       31 08 2019 15:05
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;


interface MakerInterface
{
    public function getAppDirectory();

    public function setAppDirectory($appDirectory);

    public function getNameSpace();

    public function setNameSpace($nameSpace);

    public function getModuleName();

    public function setModuleName($moduleName);

    public function getTemplateSkeleton();

    public function setTemplateSkeleton($templateSkeleton);

    public function getTemplateParameters();

    public function setTemplateParameters(array $templateParameters);

    public function getFilesPath();

    public function setFilesPath(array $filesPath);
}