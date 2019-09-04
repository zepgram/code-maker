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
use Zepgram\CodeMaker\ClassTemplate;
use Zepgram\CodeMaker\Format;

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
        $classTemplate = new ClassTemplate(
            $this->parameters['cron_name'],
            $this->maker->getModuleNamespace() . '\\Cron'
        );

        $this->parameters['class_cron'] = $classTemplate->getClassName();
        $this->parameters['name_space_cron'] = $classTemplate->getClassNamespace();
        $this->parameters['use_cron'] = $classTemplate->getClassNamespace().'\\'.$classTemplate->getClassName();
        $this->parameters['snake_case_cron'] = Format::asSnakeCase($this->parameters['use_cron']);
        $filePath = [
            'cron.tpl.php' => $classTemplate->getClassFile(),
            'crontab.tpl.php' => 'etc/crontab.xml'
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}