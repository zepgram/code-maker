<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateGraphQl.php
 * @date       18 11 2019 14:21
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatClass;

class CreateGraphQl extends BaseCommand
{
    protected static $defaultName = 'create:graph-ql';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create GraphQl');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'resolver_name' => ['Example', 'ucwords'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            'Model/Resolver/'.$this->parameters['resolver_name']
        );

        $this->parameters['class_resolver'] = $classTemplate->getName();
        $this->parameters['name_space_resolver'] = $classTemplate->getNamespace();
        $filePath = [
            'resolver.tpl.php' => $classTemplate->getFileName(),
            'schema.tpl.graphqls' => 'etc/schema.graphqls'
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}