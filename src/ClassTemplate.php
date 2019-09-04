<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       ClassGenerator.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

class ClassTemplate
{
    /**
     * @var string|null
     */
    private $className;

    /**
     * @var string
     */
    private $fullNamespace;

    /**
     * ClassGenerator constructor.
     *
     * @param string $className
     * @param string $fullNamespace
     */
    public function __construct(string $className, string $fullNamespace)
    {
        $this->className = $this->formatClassName($className);
        $this->fullNamespace = Format::ucwords($fullNamespace);
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
            $subDirectories[] = Format::ucwords($string);
        }

        return implode('/', $subDirectories);
    }

    /**
     * @return string|null
     */
    public function additionalNamespace()
    {
        $namespaces = null;
        if (strpos($this->className, '/') !== false) {
            $namespace = explode('/', $this->className);
            array_pop($namespace);
            foreach ($namespace as $item) {
                $namespaces.= "\\$item";
            }
        }

        return $namespaces;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        $namespace = explode('/', $this->className);

        return array_pop($namespace);
    }

    /**
     * @return string
     */
    public function getClassNamespace()
    {
        return $this->fullNamespace . $this->additionalNamespace();
    }

    /**
     * @return string
     */
    public function getPathForNamespace()
    {
        $names = [];
        $beforeClassName = explode('\\', $this->fullNamespace);
        unset($beforeClassName[0], $beforeClassName[1]);
        foreach ($beforeClassName as $name) {
            $names[] = Format::ucwords($name);
        }

        return str_replace('\\', '/', implode('\\', $names));
    }

    /**
     * @return string
     */
    public function getClassFile()
    {
        return $this->getPathForNamespace() . DIRECTORY_SEPARATOR . $this->className . '.php';
    }

    /**
     * @param $routerName
     *
     * @return string
     */
    public function getControllerRouteId($routerName)
    {
        $router_base = explode('\\', $this->fullNamespace)[1];

        return Format::asSnakeCase($router_base.'_'.$routerName);
    }

    /**
     * @param $routerName
     *
     * @return string
     */
    public function getControllerRoute($routerName)
    {
        $string = str_replace('.php', '', $this->getClassFile());
        $controllerPath = explode('/', $string);
        unset($controllerPath[0]);
        $route = implode('/', $controllerPath);

        return $this->getControllerRouteId($routerName).'_'.Format::asSnakeCase($route);
    }
}