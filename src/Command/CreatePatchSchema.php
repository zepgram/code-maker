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

class CreatePatchSchema extends BaseCommand
{
    protected static $defaultName = 'create:patch-schema';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create patch schema');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'patch_schema' => [
                'default' => 'UpdateSchema',
                'formatter' => 'ucwords'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Setup/Patch/Schema/'.$this->parameters['patch_schema'], 'patch.tpl.php');

        parent::execute($input, $output);
    }
}
