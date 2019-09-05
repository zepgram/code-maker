<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       ClassTemplate.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

class FormatClass
{
    /**
     * @var string|null
     */
    protected $className;

    /**
     * @var string
     */
    protected $moduleNamespace;

    /**
     * ClassGenerator constructor.
     *
     * @param string $className
     * @param string $moduleNamespace
     */
    public function __construct(string $moduleNamespace, string $className)
    {
        $this->moduleNamespace = $moduleNamespace;
        $this->className = $this->format($className);
    }

    /**
     * @param $className
     *
     * @return string
     */
    private function format($className)
    {
        $className = explode('/', $className);
        $subDirectories = [];
        foreach ($className as $string) {
            $subDirectories[] = FormatString::asCamelCase($string);
        }

        return implode('/', $subDirectories);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        $name = explode('/', $this->className);

        return array_pop($name);
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        $namespaces = null;
        $namespace = explode('/', $this->className);
        array_pop($namespace);
        foreach ($namespace as $item) {
            $namespaces.= "\\$item";
        }

        return $this->moduleNamespace . $namespaces;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->className . '.php';
    }

    /**
     * @return string
     */
    public function getUse()
    {
        return $this->getNamespace() . '\\' . $this->getName();
    }

    /**
     * @param $router
     *
     * @return string
     */
    public function getRouterId($router)
    {
        $moduleName = explode('\\', $this->moduleNamespace)[1];

        return FormatString::asSnakeCase($moduleName).'_'.FormatString::asSnakeCase($router);
    }

    /**
     * @param $router
     *
     * @return string
     */
    public function getLayoutRoute($router)
    {
        $controllerPath = explode('/', $this->className);
        unset($controllerPath[0]);

        return $this->getRouterId($router).'_'.FormatString::asSnakeCase(implode('/', $controllerPath));
    }
}