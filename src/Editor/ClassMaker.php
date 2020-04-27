<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker\Editor
 * @file       ClassMaker.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Editor;

use Zepgram\CodeMaker\Str;

class ClassMaker
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $inputClass;

    /**
     * @var string
     */
    protected $moduleNamespace;

    /**
     * @var string
     */
    protected $area;

    /**
     * @var string
     */
    protected $router;

    /**
     * ClassMaker constructor.
     *
     * @param string $moduleNamespace
     * @param string $class
     * @param array  $parameters
     */
    public function __construct(string $moduleNamespace, string $class, array $parameters = [])
    {
        $this->extractConfig($parameters);
        $this->moduleNamespace = $moduleNamespace;
        $this->inputClass = $class;
        $this->class = $this->format($class);
    }

    /**
     * @param array $extraConfig
     */
    private function extractConfig(array $extraConfig)
    {
        $this->area = $extraConfig['area'] ?? null;
        $this->router = $extraConfig['router'] ?? null;
    }

    /**
     * @param string $className
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
            $subDirectories[] = Str::asPascaleCase($string);
        }

        return implode('/', $subDirectories);
    }

    public function getBaseClassDirectory(string $className = null)
    {
        if ($className === null) {
            $className = $this->class;
        }
        return explode('/', $className)[0];
    }

    /**
     * @return string
     */
    public function getName()
    {
        $name = explode('/', $this->class);

        return array_pop($name);
    }

    /**
     * @return string
     */
    public function getNameCamelCase()
    {
        return Str::asCamelCase($this->getName());
    }

    /**
     * @return string
     */
    public function getNameSnakeCase()
    {
        return Str::asSnakeCase($this->getName());
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        $namespaces = null;
        $namespace = explode('/', $this->class);
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
        return $this->class . '.php';
    }

    /**
     * @return string
     */
    public function getUse()
    {
        return $this->getNamespace() . '\\' . $this->getName();
    }

    /**
     * @return string
     */
    public function getUseSnakeCase()
    {
        return Str::asSnakeCase($this->getUse());
    }

    /**
     * @return string
     */
    public function getUseEscaped()
    {
        return Str::asPascalCaseEscapedSlash($this->getUse());
    }

    /**
     * @return string
     */
    public function getLayoutRoute()
    {
        $controllerPath = explode('/', $this->inputClass);
        unset($controllerPath[0]);

        return Str::asSnakeCase($this->moduleNamespace) . '_' . Str::asSnakeCase(implode('/', $controllerPath));
    }

    /**
     * @return string
     */
    public function getArea()
    {
        if ($this->area === null) {
            $this->area = 'base';
        }

        return $this->area;
    }

    /**
     * @return string
     */
    public function isBackend()
    {
        return $this->getArea() === 'adminhtml';
    }
}
