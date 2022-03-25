<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\Str;

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
        $loggerPath = explode('\\', $this->maker->getModuleNamespace());
        $loggerFile = Str::lowercase($loggerPath[1]);

        return [
            'filename' => [
                'default' => $loggerFile,
                'formatter' => 'asKebabCase'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->parameters['logger_handler'] = $this->maker->getModuleNamespace().'\\Logger\\Handler';
        $this->parameters['logger_class'] = $this->maker->getModuleNamespace().'\\Logger\\Logger';
        $this->entities->addFile('di.tpl.php', 'etc/di.xml');

        parent::execute($input, $output);
    }
}
