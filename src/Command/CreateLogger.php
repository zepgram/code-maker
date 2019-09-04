<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateLogger.php
 * @date       04 09 2019 17:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatClass;
use Zepgram\CodeMaker\FormatString;

class CreateLogger extends BaseCommand
{
    protected static $defaultName = 'create:logger';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create logger');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'class_injection' => ['Zepgram\Test\Helper\Data', 'ucwords']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            $this->parameters['class_injection']
        );

        // todo: check if targeted class for injection exist

        // todo: if file exist, read it and add the dependency

        // todo: if file doesn't exist
        // -> return that virtual class as been created but targeted class could not be injected

        $filePath = [
            'di.tpl.php' => 'etc/di.xml'
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}