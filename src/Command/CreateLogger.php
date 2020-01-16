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
use Zepgram\CodeMaker\FormatClass;
use Zepgram\CodeMaker\FormatString;
use Zepgram\CodeMaker\Generator\Injection;

class CreateLogger extends BaseCommand
{
    const PSR_LOGGER_CLASS = 'Psr\Log\LoggerInterface';

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
        return [
            'class_injection' => ['Helper/Data', 'ucwords']
        ];
    }

    /**
     * @todo: resolve xml merge
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loggerPath = explode('\\', $this->maker->getModuleNamespace());
        $loggerFile = FormatString::asSnakeCase($loggerPath[0].'/'.$loggerPath[1]).'.log';

        $this->parameters['logger_handler'] = $this->maker->getModuleNamespace().'\\Logger\\Handler';
        $this->parameters['logger_class'] = $this->maker->getModuleNamespace().'\\Logger\\Logger';
        $this->parameters['logger_file'] = $loggerFile;
        $this->parameters['injected_class'] = $this->parameters['logger_class'];
        $this->parameters['parameter'] = $this->getCommandSkeleton();

        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            $this->parameters['class_injection']
        );
        $injection = new Injection(
            $classTemplate->getFileName(),
            self::PSR_LOGGER_CLASS,
            $this->getCommandSkeleton(),
            $this->maker->getModuleDirectory()
        );

        $this->parameters['class_injection'] = $classTemplate->getUse();
        $filePath = [
            'di.tpl.php' => 'etc/di.xml',
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setTemplateSkeleton(['logger', 'injection'])
            ->setFilesPath($filePath)
            ->setInjection($injection);

        parent::execute($input, $output);
    }
}