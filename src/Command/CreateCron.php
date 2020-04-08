<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateCron.php
 * @date       03 09 2019 14:30
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;

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
            'cron_name' => ['Job', 'ucwords'],
            'schedule' => ['* * * * *', null],
            'cron_group' => ['default', 'asSnakeCase'],
            'is_new_cron_group' => ['choice_question', ['no','yes']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Cron/'.$this->parameters['cron_name'], 'cron.tpl.php');
        $this->entities->addFile('crontab.tpl.php', 'etc/crontab.xml');
        if ($this->parameters['is_new_cron_group'] === 'yes') {
            $this->entities->addFile('cron_groups.tpl.php', 'etc/cron_groups.xml');
        }

        parent::execute($input, $output);
    }
}
