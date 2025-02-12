<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\Editor;

use RuntimeException;
use Zepgram\CodeMaker\Str;

class ClassMaker
{
    /**
     * @var string
     */
    protected $moduleNamespace;

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
    protected $inputParameters;

    /**
     * ClassMaker constructor.
     *
     * @param string $moduleNamespace
     * @param string $class
     * @param array  $parameters
     */
    public function __construct(string $moduleNamespace, string $class, array $parameters = [])
    {
        $this->moduleNamespace = $moduleNamespace;
        $this->class = $this->format($class);
        $this->inputClass = $class;
        $this->inputParameters = $parameters;
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
        $base = Str::asSnakeCase($this->moduleNamespace);
        if (!isset($this->inputParameters['controller']) && !isset($this->inputParameters['action'])) {
            throw new RuntimeException('Cannot create layout route: controller parameters are missing');
        }
        $controller = Str::lowercase($this->inputParameters['controller']);
        $action = Str::lowercase($this->inputParameters['action']);

        return $base . '_' . $controller . '_' . $action;
    }

    /**
     * @return string
     */
    public function getArea()
    {
        return $this->inputParameters['area'] ?? 'base';
    }

    /**
     * @return string
     */
    public function isBackend()
    {
        return $this->getArea() === 'adminhtml';
    }
}
