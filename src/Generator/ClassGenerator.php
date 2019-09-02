<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator for Caudalie
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       ClassGenerator.php
 * @date       02 09 2019 11:31
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Generator;


use Zepgram\CodeMaker\MakerInterface;

class ClassGenerator
{
    /** @var string|null */
    private $className;

    /** @var string */
    private $classType;

    /** @var string */
    private $moduleNamespace;

    /**
     * ClassGenerator constructor.
     *
     * @param string $className
     * @param string $classType
     * @param string $moduleNamespace
     */
    public function __construct(string $classType, string $className, string $moduleNamespace)
    {
        $this->classType = $classType;
        $this->className = $this->formatClassName($className);
        $this->moduleNamespace = $moduleNamespace;
    }

    /**
     * @param $className
     *
     * @return string
     */
    private function formatClassName($className)
    {
        $className = explode('/', $className);
        $subDirectories = [];
        foreach ($className as $string) {
            $subDirectories[] = ucwords($string);
        }

        return implode('/', $subDirectories);
    }

    /**
     * @return string|null
     */
    public function setNamespaceForType()
    {
        $namespaces = str_replace('/', '\\', $this->classType);
        $namespaces = "\\$namespaces";
        if (strpos($this->className, '/') !== false) {
            $namespace = explode('/', $this->className);
            array_pop($namespace);
            foreach ($namespace as $item) {
                $namespaces.= "\\$item";
            }
        }

        return $namespaces;
    }

    public function getClassName()
    {
        $namespace = explode('/', $this->className);

        return array_pop($namespace);
    }

    public function getClassNamespace()
    {
        return $this->moduleNamespace . $this->setNamespaceForType();
    }

    public function getClassPath()
    {
        return $this->classType . DIRECTORY_SEPARATOR . $this->className . '.php';
    }
}