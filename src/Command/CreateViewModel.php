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

class CreateViewModel extends BaseCommand
{
    protected static $defaultName = 'create:view-model';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create view model');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'action' => [
                'default' => 'Index',
                'formatter' => 'asCamelCase'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('ViewModel/'.$this->parameters['action'], 'view_model.tpl.php');

        parent::execute($input, $output);
    }
}
