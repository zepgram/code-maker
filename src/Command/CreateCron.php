<?php
/**
 * This file is part of Zepgram\CodeMaker\Command for Caudalie
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateCron.php
 * @date       03 09 2019 14:01
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatClass;
use Zepgram\CodeMaker\FormatString;

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
            'schedule' => ['* * * * *', null]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            'Cron/'.$this->parameters['cron_name']
        );

        $this->parameters['class_cron'] = $classTemplate->getName();
        $this->parameters['name_space_cron'] = $classTemplate->getNamespace();
        $this->parameters['use_cron'] = $classTemplate->getUse();
        $this->parameters['snake_case_cron'] = FormatString::asSnakeCase($this->parameters['use_cron']);
        $filePath = [
            'cron.tpl.php' => $classTemplate->getFileName(),
            'crontab.tpl.php' => 'etc/crontab.xml'
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}