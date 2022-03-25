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

class CreatePatchData extends BaseCommand
{
    protected static $defaultName = 'create:patch-data';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create patch data');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'patch_name' => [
                'default' => 'UpdateData',
                'formatter' => 'ucwords'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Setup/Patch/Data/'.$this->parameters['patch_name'], 'patch.tpl.php');

        parent::execute($input, $output);
    }
}
