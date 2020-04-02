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
     * @var string
     */
    protected $area;

    /**
     * ClassGenerator constructor.
     *
     * @param string      $moduleNamespace
     * @param string      $className
     * @param string|null $area
     */
    public function __construct(string $moduleNamespace, string $className, string $area = '')
    {
        $this->area = $area;
        $this->moduleNamespace = $moduleNamespace;
        $this->className = $this->format($className);
    }

    /**
     * @param $className
     *
     * @return string
     */
    private function format(string $className)
    {
        $classNameExploded = explode('/', $className);
        $subDirectories = [];
        foreach ($classNameExploded as $key => $string) {
            $baseClassDirectory = $this->getBaseClassDirectory($className);
            if ($key === 1 && $this->isBackend() &&
                ($baseClassDirectory === 'Block' || $baseClassDirectory === 'Controller')) {
                $subDirectories[] = 'Adminhtml';
            }
            $subDirectories[] = FormatString::asPascaleCase($string);
        }

        return implode('/', $subDirectories);
    }

    public function getBaseClassDirectory(string $className = null)
    {
        if ($className === null) {
            $className = $this->className;
        }
        return explode('/', $className)[0];
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
    public function getRouteId(string $router)
    {
        $moduleName = explode('\\', $this->moduleNamespace)[1];

        return FormatString::asSnakeCase($moduleName).'_'.FormatString::asSnakeCase($router);
    }

    /**
     * @param $router
     *
     * @return string
     */
    public function getLayoutRoute(string $router)
    {
        $controllerPath = explode('/', $this->className);
        unset($controllerPath[0]);

        return $this->getRouteId($router).'_'.FormatString::asSnakeCase(implode('/', $controllerPath));
    }

    /**
     * @return bool
     */
    public function isBackend()
    {
        return $this->area === 'adminhtml';
    }
}
