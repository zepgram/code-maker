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

class CreateCron extends BaseCommand
{
    protected static $defaultName = 'create:cron';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create cron');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'cron_name' => [
                'default' => 'Job',
                'formatter' => 'ucwords'
            ],
            'schedule' => [
                'default' => '* * * * *'
            ],
            'cron_group' => [
                'default' => 'default',
                'formatter' => 'asSnakeCase'
            ],
            'is_new_cron_group' => [
                'yes_no_question'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Cron/'.$this->parameters['cron_name'], 'cron.tpl.php');
        $this->entities->addFile('crontab.tpl.php', 'etc/crontab.xml');
        if (isset($this->parameters['is_new_cron_group']) && $this->parameters['is_new_cron_group']) {
            $this->entities->addFile('cron_groups.tpl.php', 'etc/cron_groups.xml');
        }

        parent::execute($input, $output);
    }
}
