<?php

declare(strict_types=1);

namespace Zepgram\CodeMaker\Editor;

use Zepgram\CodeMaker\Maker;
use Zepgram\CodeMaker\Renderer\Templates;
use Zepgram\CodeMaker\Str;

class Entities
{
    /** @var Maker */
    private $maker;

    /** @var array */
    private $entities = [];

    /** @var array */
    private $files = [];

    public function __construct(Maker $maker)
    {
        $this->maker = $maker;
    }

    /**
     * @param string $entity
     * @param string $originFile
     */
    public function addEntity(string $entity, string $originFile)
    {
        $this->entities[$originFile] = $entity;
    }

    /**
     * @param string $originFile
     * @param string $outputPath
     */
    public function addFile(string $originFile, string $outputPath)
    {
        $this->files[$originFile] = $outputPath;
    }

    /**
     * @param array $parameters
     */
    public function populate(array $parameters)
    {
        if (!empty($this->entities)) {
            foreach ($this->entities as $originFile => $entity) {
                $class = new ClassMaker($this->maker->getModuleNamespace(), $entity, $parameters);
                $entityKey = strstr($originFile, '.', true);

                $parameters["name_$entityKey"] = $class->getName();
                $parameters["name_camel_case_$entityKey"] = $class->getNameCamelCase();
                $parameters["name_snake_case_$entityKey"] = $class->getNameSnakeCase();
                $parameters["namespace_$entityKey"] = $class->getNamespace();
                $parameters["use_$entityKey"] = $class->getUse();
                $parameters["use_snake_case_$entityKey"] = $class->getUseSnakeCase();
                $parameters["use_escaped_$entityKey"] = $class->getUseEscaped();
                $parameters["route_id"] = Str::asSnakeCase($this->maker->getModuleName());
                $parameters["router_id"] = $class->isBackend() ? 'admin' : 'standard';

                $this->files[$originFile] = $class->getFileName();
            }
        }

        $this->maker->setTemplateParameters($parameters);
        $this->maker->setFilesPath($this->files);
    }

    /**
     * @return Templates
     */
    public function initTemplates()
    {
        return new Templates($this->maker);
    }
}
