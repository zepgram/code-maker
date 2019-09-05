<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       Templates.php
 * @date       05 09 2019 10:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Generator;

use Zepgram\CodeMaker\File\Management;

class Injection
{
    public $parameters;

    /**
     * Injection constructor.
     *
     * @param string $targetClass
     * @param string $sourceClass
     * @param string $parameter
     */
    public function __construct(string $targetClass, string $sourceClass, string $parameter)
    {
        $this->parameters['target_class'] = $targetClass;
        $this->parameters['source_class'] = $sourceClass;
        $this->parameters['parameter'] = $parameter;
    }

    /**
     * @todo: refacto + add xml node
     * @return array|null
     */
    public function appendInjection()
    {
        $fileContent = null;
        $appendContent = null;
        $filePath = $this->parameters['target_class'];
        $fileName = explode('\\', $this->parameters['source_class']);
        $this->parameters['source_class_name'] = array_pop($fileName);
        $content = Management::contentFile($filePath);

        // content
        $baseContent = strstr($content, '{');
        $classContent = $this->removeFirstOccurrence($baseContent, '{');
        $constructBefore = strstr($content, '__construct', true);
        $construct = strstr($content, '__construct');

        // header
        $classHeader = strstr($content, '{', true);
        $classHeaderBefore = strstr($classHeader, 'use', true);
        $classHeaderAppend = strstr($classHeader, 'use');
        $use = strstr($content, $this->parameters['source_class']);
        if ($use === false) {
            $classHeaderAppend = 'use '. $this->parameters['source_class'] . ";\r\n" . $classHeaderAppend;
            $classHeader = $classHeaderBefore.$classHeaderAppend;
        }

        // create construct
        if ($construct === false) {
            $absolutePathToSkeleton = dirname(__DIR__) . '/Resources/skeleton/virtual/construct.tpl.php';
            $appendContent = Management::parseTemplate($absolutePathToSkeleton, $this->parameters);
            $fileContent = $classHeader.'{'.$appendContent.$classContent;
        } else {
            // append to construct
            $bracketBefore = strstr($construct, ')', true);
            $instanceValue = $this->parameters['source_class_name'].' $'.$this->parameters['parameter'];
            $parameter = strstr($content, $instanceValue);
            if ($parameter === false) {
                $headerContent = $constructBefore . $bracketBefore . ", $instanceValue) \r\n" . str_pad('{',5, ' ', STR_PAD_LEFT);
                $variables = strstr($construct, '{');
                $variables = $this->removeFirstOccurrence($variables, '{');
                $param = $this->parameters['parameter'];
                $variableValue = "\r\n". str_pad('$',9, ' ', STR_PAD_LEFT) . 'this->'.$param.' = $'.$param.';';
                $variable = strstr($content, $variableValue);
                if ($variable === false && isset($headerContent)) {
                    $fileContent = $headerContent . $variableValue . $variables;
                    $classHeaderBefore = strstr($fileContent, 'use', true);
                    $classHeaderAppend = strstr($fileContent, 'use');
                    $use = strstr($fileContent, $this->parameters['source_class']);
                    if ($use === false) {
                        $classHeaderAppend = 'use ' . $this->parameters['source_class'] . ";\r\n" . $classHeaderAppend;
                        $fileContent = $classHeaderBefore . $classHeaderAppend;
                    }
                }
            }
        }


        $path = explode('/', $filePath);
        unset($path[0],$path[1]);
        $path = implode('/', $path);

        return [$path, $fileContent];
    }

    /**
     * @param $str
     * @param $strFind
     *
     * @return mixed
     */
    public function removeFirstOccurrence($str, $strFind)
    {
        $pos = strpos($str, $strFind);

        if ($pos !== false) {
            $str = substr_replace($str, '', $pos, strlen($strFind));
        }

        return $str;
    }
}