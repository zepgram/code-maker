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

class CreateCommand extends BaseCommand
{
    protected static $defaultName = 'create:command';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create console command');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'class_command' => ['ConfigShow', 'ucwords'],
            'command' => ['config:show', null]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            'Console/Command/'.$this->parameters['class_command']
        );

        $commandNode = lcfirst(explode('\\', $classTemplate->getNamespace())[1]).$classTemplate->getName();
        $this->parameters['class_command'] = $classTemplate->getName();
        $this->parameters['class_command_node'] = $commandNode;
        $this->parameters['name_space_command'] = $classTemplate->getNamespace();
        $this->parameters['use_command'] = $classTemplate->getUse();
        $filePath = [
            'command.tpl.php' => $classTemplate->getFileName(),
            'di.tpl.php' => 'etc/di.xml'
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
