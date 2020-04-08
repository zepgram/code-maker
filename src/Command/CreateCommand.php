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
        $this->entities->addEntity('Console/Command/'.$this->parameters['class_command'], 'command.tpl.php');
        $this->entities->addFile('di.tpl.php', 'etc/di.xml');

        parent::execute($input, $output);
    }
}
