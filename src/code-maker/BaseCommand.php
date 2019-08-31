<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       AbstractCommand.php
 * @date       31 08 2019 15:43
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zepgram\CodeMaker\Generator\Templates;

class BaseCommand extends Command
{
    const MAGENTO_DEVELOPMENT_DIRECTORY = '/app/code/';

    /**
     * @var Maker
     */
    public $generator;

    /** @var string */
    public $module;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $helper       = $this->getHelper('question');
        $question     = new Question('<comment>Please enter the name of the module (ex: Zepgram_Test): </comment>', 'Zepgram_Test');
        $this->module = $helper->ask($input, $output, $question);

        if (strpos($this->module, '_') === false) {
            throw new \InvalidArgumentException('Namespace and module name must be separated by "_"');
        }
        list($namespace, $moduleName) = explode('_', $this->module);

        $this->generator = new Maker();
        $this->generator
            ->setNameSpace($namespace)
            ->setModuleName($moduleName)
            ->setAppDirectory($this->getAppDirectory())
            ->setTemplateSkeleton($this->getCommandSkeleton());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->moduleExist() && $this->getName() === 'create:module') {
            $output->writeln("<info>Module '$this->module' already exist</info>");
            $question = new ConfirmationQuestion('Do you want to override existing files ?');
            if (!$this->getHelper('question')->ask($input, $output, $question)) {
                return;
            }
        }
        $this->generator
            ->setTemplateParameters([
                'module_name' => ucfirst($this->generator->getModuleName()),
                'module_namespace' => ucfirst($this->generator->getNamespace()),
                'composer_namespace' => strtolower($this->generator->getNamespace()),
                'composer_module' => strtolower($this->generator->getModuleName())
            ])
            ->setFilesPath([
                'module.tpl.php'       => 'etc/module.xml',
                'registration.tpl.php' => 'registration.php',
                'composer.tpl.php'     => 'composer.json'
            ]);
        $template = new Templates($this->generator);
        $template->writeTemplates();
        $output->writeln("<info>Module $this->module has been successfully created</info>");
    }

    private function moduleExist()
    {
        return file_exists($this->getAppDirectory().$this->generator->getNamespace().
            DIRECTORY_SEPARATOR.$this->generator->getModuleName().'/registration.php');
    }

    /**
     * @return string
     */
    private function getAppDirectory()
    {
        return getcwd() . self::MAGENTO_DEVELOPMENT_DIRECTORY;
    }

    /**
     * @return mixed
     */
    private function getCommandSkeleton()
    {
        return explode(':', $this->getName())[1];
    }
}
