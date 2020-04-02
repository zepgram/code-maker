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
use Zepgram\CodeMaker\FormatString;

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
        $loggerFile = FormatString::asSnakeCase($loggerPath[0].'/'.$loggerPath[1]).'.log';

        return [
            'filename' => [$loggerFile, 'lowercase']
        ];
    }

    /**
     * @todo: resolve xml merge
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->parameters['logger_file'] = $this->parameters['filename'];
        $this->parameters['logger_handler'] = $this->maker->getModuleNamespace().'\\Logger\\Handler';
        $this->parameters['logger_class'] = $this->maker->getModuleNamespace().'\\Logger\\Logger';

        $filePath = [
            'di.tpl.php' => 'etc/di.xml',
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setTemplateSkeleton(['logger'])
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
